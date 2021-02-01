<?php

namespace App\Responder;

use Symfony\Component\Form\FormView;

class LoginResponder
{
    private FormView $form;

    public function __construct(FormView $form)
    {
        $this->form = $form;
    }

    public function getForm(): FormView
    {
        return $this->form;
    }
}