<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

namespace PrestaShop\Module\PsEventbus\Api\Post;

use Psr\Http\Message\StreamInterface;

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Post file upload
 */
class PostFileApi implements PostFileInterface
{
    /** @var string */
    private $name;

    /** @var string|null */
    private $filename;

    /** @var StreamInterface|MultipartBody|mixed */
    private $content;

    /** @var array<mixed> */
    private $headers = [];

    /**
     * @param string $name Name of the form field
     * @param StreamInterface|MultipartBody|string $content Data to send
     * @param string|null $filename Filename content-disposition attribute
     * @param array<mixed> $headers Array of headers to set on the file (can override any default headers)
     *
     * @@throws \RuntimeException when filename is not passed or can't be determined
     */
    public function __construct(
        $name,
        $content,
        $filename = null,
        array $headers = []
    ) {
        $this->headers = $headers;
        $this->name = $name;
        $this->prepareContent($content);
        $this->prepareFilename($filename);
        $this->prepareDefaultHeaders();
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getFilename()
    {
        return $this->filename;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Prepares the contents of a POST file.
     *
     * @param StreamInterface|MultipartBody|string $content Content of the POST file
     *
     * @return void
     */
    private function prepareContent($content)
    {
        $this->content = $content;

        if (!($this->content instanceof StreamInterface)) {
            $this->content = Stream::factory($this->content);
        } elseif ($this->content instanceof MultipartBody) {
            if (!$this->hasHeader('Content-Disposition')) {
                $disposition = 'form-data; name="' . $this->name . '"';
                $this->headers['Content-Disposition'] = $disposition;
            }

            if (!$this->hasHeader('Content-Type')) {
                $this->headers['Content-Type'] = sprintf(
                    'multipart/form-data; boundary=%s',
                    $this->content->getBoundary()
                );
            }
        }
    }

    /**
     * Applies a file name to the POST file based on various checks.
     *
     * @param string|null $filename Filename to apply (or null to guess)
     *
     * @return void
     */
    private function prepareFilename($filename)
    {
        $this->filename = $filename;

        if (!$this->filename) {
            $this->filename = $this->content->getMetadata('uri');
        }

        if (!$this->filename || substr($this->filename, 0, 6) === 'php://') {
            $this->filename = $this->name;
        }
    }

    /**
     * Applies default Content-Disposition and Content-Type headers if needed.
     *
     * @return void
     */
    private function prepareDefaultHeaders()
    {
        // Set a default content-disposition header if one was no provided
        if (!$this->hasHeader('Content-Disposition')) {
            $this->headers['Content-Disposition'] = sprintf(
                'form-data; name="%s"; filename="%s"',
                $this->name,
                basename(is_null($this->filename) ? '' : $this->filename)
            );
        }

        // Set a default Content-Type if one was not supplied
        if (!$this->hasHeader('Content-Type')) {
            $this->headers['Content-Type'] = 'text/plain';
        }
    }

    /**
     * Check if a specific header exists on the POST file by name.
     *
     * @param string $name Case-insensitive header to check
     *
     * @return bool
     */
    private function hasHeader($name)
    {
        return isset(array_change_key_case($this->headers)[strtolower($name)]);
    }
}
