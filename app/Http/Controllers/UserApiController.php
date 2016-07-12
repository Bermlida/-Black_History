<?php

namespace App\Http\Controllers;

use Storage;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Post;

class UserApiController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $json = response()->json($users);

        Storage::disk('local')->put('users.json', $json);
        return response()->download('/home/tkb-user/projects/laravel/storage/app/users.json', 'users_json');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        //$user = new User();
        //$user->name = $request->input('name');
        //$user->email = $request->input('email');
        //$user->password = $request->input('password');
        //$user.save();
        //return json_encode($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user_api)
    {
        return response()->json($user_api);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {        
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->save();

        if ($request->has('callback')) {
            $callback =  $request->input('callback');

            return response()
                        ->json($post)
                        ->setCallback($callback);
        } else {
            return response()->json($post);
        }        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
