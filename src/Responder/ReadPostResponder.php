<?php

namespace App\Responder;

use App\Entity\Post;
use App\Representation\RepresentationInterface;
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

    public function getRepresentation()
    {
        return $this->representation;
    }

    public function getForm()
    {
        return $this->form;
    }
}