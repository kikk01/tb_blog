<?php

namespace App\Domain\Blog\Presenter;

use Symfony\Component\HttpFoundation\Response;
use App\Domain\Blog\Responder\UpdatePostResponder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Domain\Blog\Responder\RedirectUpdatePostResponder;

interface UpdatePostPresenterInterface
{
    public function redirect(RedirectUpdatePostResponder $responder): RedirectResponse;

    public function present(UpdatePostResponder $responder): Response;
}