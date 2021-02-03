<?php

namespace App\Domain\User\Responder;

use Symfony\Component\Form\FormView;

class RegistrationResponder
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