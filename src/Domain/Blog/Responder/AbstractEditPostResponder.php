<?php

namespace App\Domain\Blog\Responder;

use Symfony\Component\Form\FormView;

abstract class AbstractEditPostResponder
{
    private FormView $form;

    public function __construct(FormView $form)
    {
        $this->form = $form;
    }

    public function getForm()
    {
        return $this->form;
    }
}