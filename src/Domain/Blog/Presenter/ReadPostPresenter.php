<?php

namespace App\Domain\Blog\Presenter;

use Twig\Environment;
use Symfony\Component\HttpFoundation\Response;
use App\Domain\Blog\Responder\ReadPostResponder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Domain\Blog\Responder\RedirectReadPostResponder;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ReadPostPresenter implements ReadPostPresenterInterface
{
    private Environment $twig;

    private UrlGeneratorInterface $urlGenerator;

    public function __construct(Environment $twig, UrlGeneratorInterface $urlGenerator)
    {
        $this->twig = $twig;
        $this->urlGenerator = $urlGenerator;
    }

    public function redirect(RedirectReadPostResponder $responder): RedirectResponse
    {
        return new RedirectResponse($this->urlGenerator->generate(
            "blog_read",
            ["id" => $responder->getPost()->getId()]
        ));

    }

    public function present(ReadPostResponder $responder): Response
    {
            return new Response($this->twig->render('blog/read.html.twig', [
                'post' => $responder->getPost(),
                "form" => $responder->getForm()
            ]));
    }
}