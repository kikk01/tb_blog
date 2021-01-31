<?php

namespace App\Presenter;

use App\Responder\ListingPostsResponder;
use Symfony\Component\HttpFoundation\Response;

interface ListingPostsPresenterInterface
{
    public function present(ListingPostsResponder $responder): Response;
}