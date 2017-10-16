<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 2017/7/4
 * Time: 下午4:26
 */

namespace App\Services;
use App\Contracts\TestContract;

class TestService implements TestContract
{
    public function callMe($controller)
    {
        dd('Call me From TestServiceProvider in'.$controller);
    }
}