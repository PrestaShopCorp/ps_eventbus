<?php

namespace PrestaShop\Module\PsEventbus\Api\Post;

use GuzzleHttp\Psr7\AppendStream;
use GuzzleHttp\Psr7\StreamDecoratorTrait;
use Psr\Http\Message\StreamInterface;

/**
 * Stream that when read returns bytes for a streaming multipart/form-data body
 */
class MultipartBody implements StreamInterface
{
    use StreamDecoratorTrait;

    /** @var string */
    private $boundary;

    /**
     * @param array $fields associative array of field names to values where
     *                      each value is a string or array of strings
     * @param array $files Associative array of PostFileInterface objects
     * @param string $boundary You can optionally provide a specific boundary
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(
        array $fields = [],
        array $files = [],
              $boundary = null
    ) {
        $this->boundary = $boundary ?: uniqid();
        $this->stream = $this->createStream($fields, $files);
    }

    /**
     * Get the boundary
     *
     * @return string
     */
    public function getBoundary()
    {
        return $this->boundary;
    }

    public function isWritable()
    {
        return false;
    }

    /**
     * Get the string needed to transfer a POST field
     *
     * @param string $name
     * @param string $value
     *
     * @return string
     */
    private function getFieldString($name, $value)
    {
        return sprintf(
            "--%s\r\nContent-Disposition: form-data; name=\"%s\"\r\n\r\n%s\r\n",
            $this->boundary,
            $name,
            $value
        );
    }

    /**
     * Get the headers needed before transferring the content of a POST file
     *
     * @param PostFileInterface $file
     *
     * @return string
     */
    private function getFileHeaders(PostFileInterface $file)
    {
        $headers = '';
        foreach ($file->getHeaders() as $key => $value) {
            $headers .= "{$key}: {$value}\r\n";
        }

        return "--{$this->boundary}\r\n" . trim($headers) . "\r\n\r\n";
    }

    /**
     * Create the aggregate stream that will be used to upload the POST data
     *
     * @param array $fields
     * @param array $files
     *
     * @return AppendStream
     */
    protected function createStream(array $fields, array $files)
    {
        $stream = new AppendStream();

        foreach ($fields as $name => $fieldValues) {
            foreach ((array) $fieldValues as $value) {
                $stream->addStream(
                    Stream::factory($this->getFieldString($name, $value))
                );
            }
        }

        foreach ($files as $file) {
            if (!$file instanceof PostFileInterface) {
                throw new \InvalidArgumentException('All POST fields must implement PostFieldInterface');
            }

            $stream->addStream(
                Stream::factory($this->getFileHeaders($file))
            );
            $stream->addStream($file->getContent());
            $stream->addStream(Stream::factory("\r\n"));
        }

        // Add the trailing boundary with CRLF
        $stream->addStream(Stream::factory("--{$this->boundary}--\r\n"));

        return $stream;
    }
}
