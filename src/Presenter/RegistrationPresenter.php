<?php

namespace App\Presenter;

use Twig\Environment;
use App\Responder\ReadPostResponder;
use App\Responder\RegistrationResponder;
use App\Responder\RedirectReadPostResponder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RegistrationPresenter implements RegistrationPresenterInterface
{
    private Environment $twig;

    private UrlGeneratorInterface $urlGenerator;

    public function __construct(Environment $twig, UrlGeneratorInterface $urlGenerator)
    {
        $this->twig = $twig;
        $this->urlGenerator = $urlGenerator;
    }

    public function redirect(): RedirectResponse
    {
        return new RedirectResponse($this->urlGenerator->generate('security_login'));
    }

    public function present(RegistrationResponder $responder): Response
    {
            return new Response($this->twig->render('registration.html.twig', [
                "form" => $responder->getForm()
            ]));
    }
}