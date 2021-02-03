<?php

namespace App\Domain\Blog\Presenter;

use Symfony\Component\HttpFoundation\Response;
use App\Domain\Blog\Responder\CreatePostResponder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Domain\Blog\Responder\RedirectCreatePostResponder;

interface CreatePostPresenterInterface
{
    public function redirect(RedirectCreatePostResponder $responder): RedirectResponse;

    public function present(CreatePostResponder $responder): Response;
}