<?php

namespace App\Presenter;

use App\Responder\LoginResponder;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class LoginPresenter implements LoginPresenterInterface
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function present(LoginResponder $responder): Response
    {
        return new Response($this->twig->render('security/login.html.twig', [
            'form' => $responder->getForm()
        ]));
    }
}