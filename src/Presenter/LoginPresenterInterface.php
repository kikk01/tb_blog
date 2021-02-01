<?php

namespace App\Presenter;

use App\Responder\LoginResponder;
use Symfony\Component\HttpFoundation\Response;

interface LoginPresenterInterface
{
    public function present(LoginResponder $responder): Response;
}