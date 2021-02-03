<?php

namespace App\Domain\Security\Responder;

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