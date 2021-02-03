<?php

namespace App\Domain\Blog\Presenter;

use Symfony\Component\HttpFoundation\Response;
use App\Domain\Blog\Responder\ReadPostResponder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Domain\Blog\Responder\RedirectReadPostResponder;

interface ReadPostPresenterInterface
{
    public function redirect(RedirectReadPostResponder $responder): RedirectResponse;

    public function present(ReadPostResponder $responder): Response;
}