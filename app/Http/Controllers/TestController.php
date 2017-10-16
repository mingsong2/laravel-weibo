<?php

namespace App\Http\Controllers;
use App;
use App\Contracts\TestContract;
use Illuminate\Http\Request;
use App\Facades\TestClass;
class TestController extends Controller
{
    public function __construct(TestContract $test)
    {
        $this->test=$test;
    }
    public function index(){
//        var_dump($this->test);exit;
//        $this->test->callMe('TestController');
        TestClass::doSomething();
    }
    public function textGit(){
        
    }
}
