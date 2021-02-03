<?php

namespace App\Domain\Blog\Presenter;

use Twig\Environment;
use Symfony\Component\HttpFoundation\Response;
use App\Domain\Blog\Responder\ListingPostsResponder;

class ListingPostsPresenter implements ListingPostsPresenterInterface
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function present(ListingPostsResponder $responder): Response
    {
        return new Response($this->twig->render('blog/index.html.twig', [
            'representation' => $responder->getRepresentation()
        ]));
    }
}