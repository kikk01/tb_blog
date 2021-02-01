<?php

namespace App\Presenter;

use App\Responder\CreatePostResponder;
use App\Responder\RedirectCreatePostResponder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

interface CreatePostPresenterInterface
{
    public function redirect(RedirectCreatePostResponder $responder): RedirectResponse;

    public function present(CreatePostResponder $responder): Response;
}