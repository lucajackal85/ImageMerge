<?php

namespace Jackal\ImageMerge\Test\UnitTest\Loader;

use Jackal\ImageMerge\Exception\InvalidUrlException;
use Jackal\ImageMerge\Loader\UrlLoader;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class UrlLoaderTest extends TestCase
{
    public static function forbiddenUrls(): array
    {
        return [
            'file scheme' => ['file:///etc/passwd'],
            'php filter' => ['php://filter/resource=/etc/passwd'],
            'phar' => ['phar:///tmp/x.phar/image.png'],
            'gopher' => ['gopher://127.0.0.1:6379/_x'],
            'ftp' => ['ftp://example.com/image.png'],
            'data' => ['data://text/plain;base64,AAAA'],
            'no host' => ['http:///image.png'],
            'loopback' => ['http://127.0.0.1/image.png'],
            'localhost' => ['http://localhost/image.png'],
            'cloud metadata' => ['http://169.254.169.254/latest/meta-data'],
            'private 10/8' => ['http://10.0.0.1/image.png'],
            'private 192.168/16' => ['https://192.168.1.1/image.png'],
            'carrier-grade nat' => ['http://100.64.0.1/image.png'],
            'unspecified' => ['http://0.0.0.0/image.png'],
            'ipv6 loopback' => ['http://[::1]/image.png'],
            'ipv6 unique local' => ['http://[fd00::1]/image.png'],
        ];
    }

    #[DataProvider('forbiddenUrls')]
    public function testItRejectsForbiddenUrls(string $url): void
    {
        $this->expectException(InvalidUrlException::class);

        (new UrlLoader())->assertAllowed($url);
    }

    public function testItAcceptsPublicAddress(): void
    {
        (new UrlLoader())->assertAllowed('https://8.8.8.8/image.png');

        $this->addToAssertionCount(1);
    }

    public function testPrivateNetworksCanBeExplicitlyAllowed(): void
    {
        (new UrlLoader(allowPrivateNetworks: true))->assertAllowed('http://127.0.0.1/image.png');

        $this->addToAssertionCount(1);
    }

    public function testSchemeCheckStillAppliesWhenPrivateNetworksAllowed(): void
    {
        $this->expectException(InvalidUrlException::class);

        (new UrlLoader(allowPrivateNetworks: true))->assertAllowed('file:///etc/passwd');
    }
}
