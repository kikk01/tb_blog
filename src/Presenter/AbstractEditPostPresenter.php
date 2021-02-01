<?php

namespace App\Presenter;

use App\Responder\AbstractEditPostResponder;
use Twig\Environment;
use Symfony\Component\HttpFoundation\Response;
use App\Responder\AbstractRedirectPostResponder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

abstract class AbstractEditPostPresenter
{
    private Environment $twig;

    private UrlGeneratorInterface $urlGenerator;

    abstract protected function getView(): string;

    public function __construct(Environment $twig, UrlGeneratorInterface $urlGenerator)
    {
        $this->twig = $twig;
        $this->urlGenerator = $urlGenerator;
    }
    
    public function redirect(AbstractRedirectPostResponder $responder): RedirectResponse
    {
        return new RedirectResponse($this->urlGenerator->generate(
            "blog_read",
            ["id" => $responder->getPost()->getId()]
        ));
    }


    public function present(AbstractEditPostResponder $responder): Response
    {
        return new Response($this->twig->render($this->getView(), [
            "form" => $responder->getForm()
        ]));
    }
}