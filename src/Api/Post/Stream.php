<?php
namespace PrestaShop\Module\PsEventbus\Api\Post;


use GuzzleHttp\Psr7\PumpStream;
use InvalidArgumentException;
use Iterator;
use Psr\Http\Message\StreamInterface;

/**
 * PHP stream implementation
 */
class Stream
{
    /**
     * Create a new stream based on the input type.
     *
     * This factory accepts the same associative array of options as described
     * in the constructor.
     *
     * @param resource|string|StreamInterface $resource Entity body data
     * @param array                           $options  Additional options
     *
     * @return \GuzzleHttp\Psr7\Stream|PumpStream|Stream|StreamInterface
     * @throws InvalidArgumentException if the $resource arg is not valid.
     */
    public static function factory($resource = '', array $options = [])
    {
        $type = gettype($resource);

        if ($type == 'string') {
            $stream = fopen('php://temp', 'r+');
            if ($resource !== '') {
                fwrite($stream, $resource);
                fseek($stream, 0);
            }
            return new self($stream, $options);
        }

        if ($type == 'resource') {
            return new self($resource, $options);
        }

        if ($resource instanceof StreamInterface) {
            return $resource;
        }

        if ($type == 'object' && method_exists($resource, '__toString')) {
            return self::factory((string) $resource, $options);
        }

        if (is_callable($resource)) {
            return new PumpStream($resource, $options);
        }

        if ($resource instanceof Iterator) {
            return new PumpStream(function () use ($resource) {
                if (!$resource->valid()) {
                    return false;
                }
                $result = $resource->current();
                $resource->next();
                return $result;
            }, $options);
        }

        throw new InvalidArgumentException('Invalid resource type: ' . $type);
    }

}
