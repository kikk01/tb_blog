<?php

namespace App\Presenter;

use App\Responder\RegistrationResponder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

interface RegistrationPresenterInterface
{
    public function redirect(): RedirectResponse;

    public function present(RegistrationResponder $responder): Response;
}