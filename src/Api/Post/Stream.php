<?php

namespace PrestaShop\Module\PsEventbus\Api\Post;

use GuzzleHttp\Psr7\PumpStream;
use Psr\Http\Message\StreamInterface;

/**
 * PHP stream implementation
 */
class Stream implements StreamInterface
{
    /** @var resource */
    private $stream;
    /** @var int|mixed */
    private $size;
    /** @var bool */
    private $seekable;
    /** @var bool */
    private $writable;
    /** @var bool */
    private $readable;
    /** @var string */
    private $uri;
    /** @var array<mixed> */
    private $customMetadata;

    /** @var array<mixed> Hash of readable and writable stream types */
    private static $readWriteHash = [
        'read' => [
            'r' => true, 'w+' => true, 'r+' => true, 'x+' => true, 'c+' => true,
            'rb' => true, 'w+b' => true, 'r+b' => true, 'x+b' => true,
            'c+b' => true, 'rt' => true, 'w+t' => true, 'r+t' => true,
            'x+t' => true, 'c+t' => true, 'a+' => true,
        ],
        'write' => [
            'w' => true, 'w+' => true, 'rw' => true, 'r+' => true, 'x+' => true,
            'c+' => true, 'wb' => true, 'w+b' => true, 'r+b' => true,
            'x+b' => true, 'c+b' => true, 'w+t' => true, 'r+t' => true,
            'x+t' => true, 'c+t' => true, 'a' => true, 'a+' => true,
        ],
    ];

    /**
     * Create a new stream based on the input type.
     *
     * This factory accepts the same associative array of options as described
     * in the constructor.
     *
     * @param resource|string|StreamInterface|\Iterator $resource Entity body data
     * @param array<mixed> $options Additional options
     *
     * @return \GuzzleHttp\Psr7\Stream|PumpStream|Stream|StreamInterface
     *
     * @@throws \InvalidArgumentException if the $resource arg is not valid
     */
    public static function factory($resource = '', $options = [])
    {
        if (is_string($resource)) {
            $stream = fopen('php://temp', 'r+');
            if ($resource !== '' && is_resource($stream)) {
                fwrite($stream, $resource);
                fseek($stream, 0);

                return new self($stream, $options);
            }
        }

        if (is_resource($resource)) {
            return new self($resource, $options);
        }

        if ($resource instanceof StreamInterface) {
            return $resource;
        }

        if (is_object($resource) && method_exists($resource, '__toString')) {
            return self::factory((string) $resource, $options);
        }

        if (is_callable($resource)) {
            return new PumpStream($resource, $options);
        }

        if ($resource instanceof \Iterator) {
            return new PumpStream(function () use ($resource) {
                if (!$resource->valid()) {
                    return false;
                }
                /** @var string|false|null $result */
                $result = $resource->current();
                $resource->next();

                return $result;
            }, $options);
        }

        throw new \InvalidArgumentException('Invalid resource type: ' . gettype($resource));
    }

    /**
     * This constructor accepts an associative array of options.
     *
     * - size: (int) If a read stream would otherwise have an indeterminate
     *   size, but the size is known due to foreknownledge, then you can
     *   provide that size, in bytes.
     * - metadata: (array) Any additional metadata to return when the metadata
     *   of the stream is accessed.
     *
     * @param resource $stream Stream resource to wrap
     * @param array<mixed> $options Associative array of options
     *
     * @@throws \InvalidArgumentException if the stream is not a stream resource
     */
    public function __construct($stream, $options = [])
    {
        if (!is_resource($stream)) {
            throw new \InvalidArgumentException('Stream must be a resource');
        }

        if (isset($options['size'])) {
            $this->size = $options['size'];
        }

        if (isset($options['metadata'])) {
            $this->customMetadata = $options['metadata'];
        } else {
            $this->customMetadata = [];
        }

        $this->attach($stream);
    }

    /**
     * Closes the stream when the destructed
     */
    public function __destruct()
    {
        $this->close();
    }

    public function __toString()
    {
        $this->seek(0);

        return (string) stream_get_contents($this->stream);
    }

    /**
     * @return false|string
     */
    public function getContents()
    {
        return stream_get_contents($this->stream);
    }

    public function close()
    {
        if (is_resource($this->stream)) {
            fclose($this->stream);
        }

        $this->detach();
    }

    public function detach()
    {
        $result = $this->stream;
        $this->size = $this->stream = null;
        $this->readable = $this->writable = $this->seekable = false;
        $this->uri = '';

        return $result;
    }

    /**
     * @param resource $stream
     *
     * @return void
     */
    public function attach($stream)
    {
        $this->stream = $stream;
        $meta = stream_get_meta_data($this->stream);
        $this->seekable = $meta['seekable'];
        $this->readable = isset(self::$readWriteHash['read'][$meta['mode']]);
        $this->writable = isset(self::$readWriteHash['write'][$meta['mode']]);
        /** @var string $uri */
        $uri = $this->getMetadata('uri');
        $this->uri = $uri;
    }

    /**
     * @return int|mixed|null
     */
    public function getSize()
    {
        if ($this->size !== null) {
            return $this->size;
        }

        // Clear the stat cache if the stream has a URI
        if ($this->uri) {
            clearstatcache(true, $this->uri);
        }

        $stats = fstat($this->stream);
        if (
            /* @phpstan-ignore-next-line */
            isset($stats['size'])
        ) {
            $this->size = $stats['size'];

            return $this->size;
        }

        return null;
    }

    public function isReadable()
    {
        return $this->readable;
    }

    public function isWritable()
    {
        return $this->writable;
    }

    public function isSeekable()
    {
        return $this->seekable;
    }

    public function eof()
    {
        return feof($this->stream);
    }

    /**
     * @return false|int
     */
    public function tell()
    {
        return ftell($this->stream);
    }

    /**
     * @param int|mixed $size
     *
     * @return $this
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @param int $offset
     * @param int $whence
     *
     * @return bool
     */
    public function seek($offset, $whence = SEEK_SET)
    {
        return $this->seekable && fseek($this->stream, $offset, $whence) === 0;
    }

    /**
     * @param int<1, max> $length
     *
     * @return false|string
     */
    public function read($length)
    {
        return $this->readable ? fread($this->stream, $length) : false;
    }

    /**
     * @param string $string
     *
     * @return false|int
     */
    public function write($string)
    {
        // We can't know the size after writing anything
        $this->size = null;

        return $this->writable ? fwrite($this->stream, $string) : false;
    }

    public function getMetadata($key = null)
    {
        if (!$key) {
            return $this->customMetadata + stream_get_meta_data($this->stream);
        } elseif (isset($this->customMetadata[$key])) {
            return $this->customMetadata[$key];
        }

        $meta = stream_get_meta_data($this->stream);

        return isset($meta[$key]) ? $meta[$key] : null;
    }

    /**
     * @return void
     */
    public function rewind()
    {
        $this->seek(0);
    }
}
