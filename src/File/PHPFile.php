<?php

namespace Simple\File;

class PHPFile implements File
{
    const EXTENSION = 'php';

    private $file;

    private $splFileInfo;

    public function __construct(string $file)
    {
        $this->file = $file;
        $this->splFileInfo = new \SplFileInfo($file);
    }

    public function verifyFile(): bool
    {
        return $this->splFileInfo->isReadable() && $this->splFileInfo->isWritable() && $this->splFileInfo->getExtension() === static::EXTENSION;
    }

    public function write($content)
    {
        return false;
    }

    public function read()
    {
        if ($this->verifyFile()) {
            return include $this->file;
        }
        return [];
    }

    public function exclusiveWrite($content)
    {
        return false;
    }

    public function exclusiveReading()
    {
        if ($this->verifyFile()) {
            return include $this->file;
        }
        return [];
    }
}