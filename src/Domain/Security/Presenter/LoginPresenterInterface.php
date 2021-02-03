<?php

namespace App\Domain\Security\Presenter;

use App\Domain\Security\Responder\LoginResponder;
use Symfony\Component\HttpFoundation\Response;

interface LoginPresenterInterface
{
    public function present(LoginResponder $responder): Response;
}