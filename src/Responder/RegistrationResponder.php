<?php

namespace App\Responder;

use App\Entity\Post;
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