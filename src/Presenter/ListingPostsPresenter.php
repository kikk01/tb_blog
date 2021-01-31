<?php

namespace App\Presenter;

use App\Responder\ListingPostsResponder;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

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