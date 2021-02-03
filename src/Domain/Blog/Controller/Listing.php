<?php

namespace App\Domain\Blog\Controller;

use App\Domain\Blog\Paginator\PostPaginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Domain\Blog\Responder\ListingPostsResponder;
use App\Domain\Blog\Presenter\ListingPostsPresenterInterface;
use App\Infrastructure\Representation\RepresentationFactoryInterface;

class Listing
{
    public function __invoke(
        Request $request,
        RepresentationFactoryInterface $representationFactory,
        ListingPostsPresenterInterface $presenter
    ): Response {
        $representation = $representationFactory->create(PostPaginator::class)->handleRequest($request);

        return $presenter->present(new ListingPostsResponder($representation->paginate()));
    }
}