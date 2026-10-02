<?php

namespace Jackal\ImageMerge\Loader;

use Jackal\ImageMerge\Exception\ImageLimitExceededException;
use Jackal\ImageMerge\Exception\InvalidUrlException;
use RuntimeException;

/**
 * Downloads remote images over http(s) only, refusing private, loopback,
 * link-local and reserved addresses (SSRF protection).
 *
 * Note: the host is resolved before the request is made, so a hostile DNS
 * server could still answer differently for the actual request (DNS rebinding).
 * If you load URLs supplied by untrusted users, also restrict outbound traffic
 * at the network level.
 */
final class UrlLoader
{
    private const ALLOWED_SCHEMES = ['http', 'https'];

    /**
     * @param int $timeout seconds
     * @param int $maxBytes maximum response body size
     * @param bool $allowPrivateNetworks disable the public-address check (trusted URLs only)
     */
    public function __construct(
        private readonly int $timeout = 10,
        private readonly int $maxBytes = 20 * 1024 * 1024,
        private readonly bool $allowPrivateNetworks = false,
    ) {
    }

    public function load(string $url): string
    {
        $this->assertAllowed($url);

        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'timeout' => $this->timeout,
                'follow_location' => 0,
                'max_redirects' => 0,
                'ignore_errors' => true,
                'header' => "Accept: image/*\r\n",
            ],
        ]);

        $handle = @fopen($url, 'rb', false, $context);
        if ($handle === false) {
            throw new RuntimeException(sprintf('Unable to download "%s"', $url));
        }

        try {
            $status = $this->getStatusCode(stream_get_meta_data($handle)['wrapper_data'] ?? []);
            if ($status !== 200) {
                throw new RuntimeException(sprintf('Unable to download "%s": HTTP status %s (redirects are not followed)', $url, $status ?? 'unknown'));
            }

            $content = stream_get_contents($handle, $this->maxBytes + 1);
            if ($content === false) {
                throw new RuntimeException(sprintf('Unable to read "%s"', $url));
            }

            if (strlen($content) > $this->maxBytes) {
                throw new ImageLimitExceededException(sprintf('Download exceeds the limit of %d bytes', $this->maxBytes));
            }

            return $content;
        } finally {
            fclose($handle);
        }
    }

    public function assertAllowed(string $url): void
    {
        $parts = parse_url($url);
        $scheme = strtolower($parts['scheme'] ?? '');
        $host = $parts['host'] ?? '';

        if (!in_array($scheme, self::ALLOWED_SCHEMES, true) || $host === '') {
            throw new InvalidUrlException(sprintf('URL "%s" is not allowed: only http and https URLs are supported', $url));
        }

        if ($this->allowPrivateNetworks) {
            return;
        }

        $host = trim($host, '[]');
        $ips = filter_var($host, FILTER_VALIDATE_IP) ? [$host] : $this->resolve($host);

        if (!$ips) {
            throw new InvalidUrlException(sprintf('Host "%s" cannot be resolved', $host));
        }

        foreach ($ips as $ip) {
            if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_GLOBAL_RANGE)) {
                throw new InvalidUrlException(sprintf('URL "%s" is not allowed: "%s" is not a public address', $url, $ip));
            }
        }
    }

    /**
     * @return string[]
     */
    private function resolve(string $host): array
    {
        $ips = gethostbynamel($host) ?: [];

        $records = @dns_get_record($host, DNS_AAAA) ?: [];
        foreach ($records as $record) {
            if (isset($record['ipv6'])) {
                $ips[] = $record['ipv6'];
            }
        }

        return $ips;
    }

    /**
     * @param string[] $headers
     */
    private function getStatusCode(array $headers): ?int
    {
        foreach ($headers as $header) {
            if (preg_match('#^HTTP/\S+\s+(\d{3})#', $header, $matches)) {
                return (int) $matches[1];
            }
        }

        return null;
    }
}
