<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;

class UserController extends Controller
{
    protected $user;

    /**
     * 新增一個 UserController 實例。
     *
     * @return void
     */
    public function __construct(User $user)
    {
        //print "<pre>"; $this->user = $user; var_dump($this); exit();
        /*
        $this->middleware('subscribed');
        $this->middleware('auth', [
            'only' => [
                'showPassword',
            ]
        ]);
        $this->middleware('subscribed', ['except' => [
            'showProfile',
        ]]);
        */
    }

    /**
     * 顯示給定使用者的個人資料。
     *
     * @param  int  $id
     * @return Response
     */
    public function showProfile($id)
    {

        return view('user.profile', 
            [
                'url' => route('userProfile', [$id]),
                'user' => User::findOrFail($id)
            ]);
    }

    public function showPassword($id)
    {
        return view('user.profile', 
            [
                'url' => route('userProfile', [$id]),
                'user' => User::findOrFail($id)
            ]);
    }

    public function registerUser()
    {
        $data = ['aaa' => 12345];
        $type = "text/html";
        return response()
            ->view('user.register', $data)
            ->header('Content-Type', $type);
    }
}
