<?php

namespace App\Responder;

use App\Entity\Post;

class AbstractRedirectPostResponder
{
    private Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function getPost()
    {
        return $this->post;
    }
}