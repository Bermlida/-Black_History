<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ArticleController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    // 新增文章
    public function store(Requests $request)
    {
        try {
            $this->validate($request, [
              'title'         => 'required|min:3',
              'body'          => 'required|min:30',
              'published_at'  => 'required|date',
            ]);
        } catch (Exception $e) {
            // 自己處理例外狀況
        }


        Article::create(Request:all());
        // OR
        // Article::create($request->all());

        return redirect('articles');
    }
}
