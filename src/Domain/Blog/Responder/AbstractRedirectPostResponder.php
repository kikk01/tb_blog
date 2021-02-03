<?php

namespace App\Domain\Blog\Responder;

use App\Application\Entity\Post;

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