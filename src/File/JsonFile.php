<?php

namespace Simple\File;

class JsonFile implements File
{
    private $file;

    private $splFileInfo;

    const FILE_EXTENSION = 'json';

    public function __construct(string $file)
    {
        $this->file = $file;
        $this->splFileInfo = new \SplFileInfo($this->file);
    }

    public function verifyFile(): bool
    {
        return $this->splFileInfo->isReadable() && $this->splFileInfo->isWritable() && $this->splFileInfo->getExtension() === static::FILE_EXTENSION;
    }

    public function exclusiveReading()
    {
        if (!$this->verifyFile()) {
            return false;
        }
        $jsonFileHandler = fopen($this->file, 'r+');
        $fileContent = null;
        if (flock($jsonFileHandler, LOCK_EX)) {
            $fileContent = json_decode(fread($jsonFileHandler, $this->splFileInfo->getSize()), true);
            flock($jsonFileHandler, LOCK_UN);
        }
        fclose($jsonFileHandler);
        return $fileContent;
    }

    public function exclusiveWrite($content)
    {
        if (!$this->verifyFile()) {
            return false;
        }
        $contentString = $content;
        if (is_object($content) || is_array($content)) {
            $contentString = json_encode($contentString, JSON_UNESCAPED_UNICODE);
        }
        $jsonFileHandler = fopen($this->file, 'r+');
        if (flock($jsonFileHandler, LOCK_EX)) {
            fwrite($jsonFileHandler, $contentString);
            flock($jsonFileHandler, LOCK_UN);
        }
        fclose($jsonFileHandler);
        return true;
    }

    public function read()
    {
        if (!$this->verifyFile()) {
            return [];
        }
        return json_decode(file_get_contents($this->file), true);
    }

    public function write($content)
    {
        if (!$this->verifyFile()) {
            return false;
        }
        $contentString = $content;
        if (is_object($content) || is_array($content)) {
            $contentString = json_encode($contentString, JSON_UNESCAPED_UNICODE);
        }
        file_put_contents($this->file, $contentString);
        return true;
    }

    /**
     * @return \SplFileInfo
     */
    public function getSplFileInfo(): \SplFileInfo
    {
        return $this->splFileInfo;
    }

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }

    public function store()
    {
        fclose(fopen($this->file, 'a'));
    }
}