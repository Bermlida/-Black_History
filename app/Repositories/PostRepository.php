<?php

namespace App\Repositories;

use App\Repositories\Entities\Post;

class PostRepository
{
    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }
}