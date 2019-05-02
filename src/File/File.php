<?php
/**
 * Created by PhpStorm.
 * User: company
 * Date: 2019/3/4
 * Time: 15:22
 */

namespace Simple\File;

interface File
{
    public function verifyFile(): bool;

    public function read();

    public function write($content);

    public function exclusiveReading();

    public function exclusiveWrite($content);

}