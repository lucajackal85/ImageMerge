<?php

namespace Jackal\ImageMerge\Http\Message;

use Psr\Http\Message\StreamInterface;

class ImageStream implements StreamInterface
{
    /**
     * @var string
     */
    protected $content;

    protected $position = 0;

    /**
     * @param string $content
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->content;
    }

    public function close()
    {
        // TODO: Implement close() method.
    }

    /**
     * Separates any underlying resources from the stream.
     *
     * After the stream has been detached, the stream is in an unusable state.
     *
     * @return resource|null Underlying PHP stream, if any
     */
    public function detach()
    {
        return null;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return strlen($this->content);
    }

    /**
     * @return int
     */
    public function tell()
    {
        return $this->position;
    }

    /**
     * @return bool
     */
    public function eof()
    {
        return $this->position == $this->getSize();
    }

    /**
     * @return bool
     */
    public function isSeekable()
    {
        return true;
    }

    /**
     * @param int $offset
     * @param int $whence
     */
    public function seek($offset, $whence = SEEK_SET)
    {
        $this->position = $offset;
    }

    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * @return bool
     */
    public function isWritable()
    {
        return false;
    }

    /**
     * Write data to the stream.
     *
     * @param string $string The string that is to be written.
     * @return int Returns the number of bytes written to the stream.
     * @throws \RuntimeException on failure.
     */
    public function write($string)
    {
        throw new \RuntimeException('This stream is not writable');
    }

    /**
     * @return bool
     */
    public function isReadable()
    {
        return true;
    }

    /**
     * @param int $length
     * @return bool|string
     */
    public function read($length)
    {
        $read = substr($this->content,$this->position,$length);
        $this->position = $this->position+$length;
        return $read;
    }

    /**
     * @return string
     */
    public function getContents()
    {
        return (string)$this->content;
    }

    /**
     * @param null $key
     * @return null
     */
    public function getMetadata($key = null)
    {
        return null;
    }
}