<?php

namespace App\Domain\Security\Presenter;

use Twig\Environment;
use App\Domain\Security\Responder\LoginResponder;
use App\Domain\Security\Presenter\LoginPresenterInterface;
use Symfony\Component\HttpFoundation\Response;

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