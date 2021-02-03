<?php

namespace App\Domain\Blog\Responder;

use App\Application\Entity\Post;
use Symfony\Component\Form\FormView;

class ReadPostResponder
{
    private Post $post;
    private FormView $form;

    public function __construct(Post $post, FormView $form)
    {
        $this->post = $post;
        $this->form = $form;
    }

    public function getPost()
    {
        return $this->post;
    }

    public function getForm()
    {
        return $this->form;
    }
}