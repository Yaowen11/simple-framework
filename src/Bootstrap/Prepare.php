<?php
/**
 * Created by PhpStorm.
 * User: company
 * Date: 2019/3/4
 * Time: 14:52
 */

namespace Simple\Bootstrap;


interface Prepare
{
    public function verifyRequest(): bool;

    public function verifyRoute(): bool ;

    public function prepare(): \SplQueue;

}