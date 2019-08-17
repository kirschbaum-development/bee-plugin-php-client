<?php

namespace KirschbaumDevelopment\Bee\Resources;

class Pdf
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $filename;

    /**
     * @var string
     */
    protected $pageSize;

    /**
     * @var string
     */
    protected $pageOrientation;

    /**
     * @var string
     */
    protected $contentType;

    public function __construct($pdfData)
    {
        $this->url = $pdfData['url'] ?? null;
        $this->filename = $pdfData['filename'] ?? null;
        $this->pageSize = $pdfData['page_size'] ?? null;
        $this->pageOrientation = $pdfData['page_orientation'] ?? null;
        $this->contentType = $pdfData['content_type'] ?? 'application/pdf';
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @return string
     */
    public function getPageSize()
    {
        return $this->pageSize;
    }

    /**
     * @return string
     */
    public function getPageOrientation()
    {
        return $this->pageOrientation;
    }

    /**
     * @return string
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getUrl();
    }
}
