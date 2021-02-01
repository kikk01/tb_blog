<?php

namespace App\Presenter;

use App\Responder\UpdatePostResponder;
use App\Responder\RedirectUpdatePostResponder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

interface UpdatePostPresenterInterface
{
    public function redirect(RedirectUpdatePostResponder $responder): RedirectResponse;

    public function present(UpdatePostResponder $responder): Response;
}