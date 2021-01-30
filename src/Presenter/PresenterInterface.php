<?php

namespace App\Presenter;

use App\Responder\ResponderInterface;
use Symfony\Component\HttpFoundation\Response;

interface PresenterInterface
{
    public function present(ResponderInterface $responder): Response;
}