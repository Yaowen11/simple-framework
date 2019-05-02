<?php

namespace Simple\File;

class LogFile implements File
{
    private $file;

    private $splFileInfo;

    const FILE_EXTENSION = 'log';

    public function __construct($file)
    {
        $this->file = $file;
        $this->splFileInfo = new \SplFileInfo($file);
    }

    public function read()
    {
        return json_decode(file_get_contents($this->file), true);
    }

    public function write($content)
    {
        $contentString = '';
        if (is_string($content)) {
            $contentString = $content . PHP_EOL;
        }
        if (is_array($content) || is_object($content)) {
            $contentString = json_encode($content, JSON_UNESCAPED_UNICODE) . PHP_EOL;
        }
        file_put_contents($this->file, $contentString, FILE_APPEND);
        return true;
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

    public function verifyFile(): bool
    {
        return $this->splFileInfo->isReadable() && $this->splFileInfo->isWritable() && $this->splFileInfo->getExtension() === static::FILE_EXTENSION;
    }
}