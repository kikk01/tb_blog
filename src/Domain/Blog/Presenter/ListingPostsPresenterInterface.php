<?php

namespace App\Domain\Blog\Presenter;

use Symfony\Component\HttpFoundation\Response;
use App\Domain\Blog\Responder\ListingPostsResponder;

interface ListingPostsPresenterInterface
{
    public function present(ListingPostsResponder $responder): Response;
}