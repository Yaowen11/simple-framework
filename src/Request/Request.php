<?php
/**
 * Created by PhpStorm.
 * User: company
 * Date: 2019/3/4
 * Time: 14:13
 */

namespace Simpale\Request;


interface Request
{
    public function getParams(): array ;

    public function has(string $key): bool ;

    public function getParam(string $key);

    public function hasHeader(string $key): bool ;

    public function getHeaders(): array ;

    public function getHeader(string $key);
}