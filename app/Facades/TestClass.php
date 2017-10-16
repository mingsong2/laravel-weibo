<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 2017/7/4
 * Time: 下午5:16
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Facades\Test;

class TestClass extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "test";
    }
}