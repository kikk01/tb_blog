<?php

namespace App\Presenter;

use App\Responder\ReadPostResponder;
use App\Responder\RedirectReadPostResponder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

interface ReadPostPresenterInterface
{
    public function redirect(RedirectReadPostResponder $responder): RedirectResponse;

    public function present(ReadPostResponder $responder): Response;
}