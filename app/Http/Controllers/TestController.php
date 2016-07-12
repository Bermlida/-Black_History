<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App;
use TEST;
use App\Services\TestService;

class TestController extends Controller
{
    //依赖注入
    public function __construct(TestService $test){
        //$this->test = $test;
        //print url('testssss'); print '<br>';
        $this->test = new TestService('123456789');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     * @author LaravelAcademy.org
     */
    public function getIndex()
    {
        // $test = App::make('test');
        // $test->callMe('TestController');
        //$this->test->callMe('TestController');
        TEST::callMe('ABC');
    }

    //...//其他控制器动作
}