<?php

namespace App\Services;

use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use App\Repositories\PostRepository;

class PostService
{
    
    protected $mailer;
    protected $messager;
    protected $post_repository;

    public function __construct(Mailer $mailer, Message $messager, PostRepository $post_repository)
    {
        $this->mailer = $mailer;
        $this->messager = $messager;
        $this->post_repository = $post_repository;
    }
}