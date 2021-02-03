<?php

namespace App\Domain\Blog\Presenter;

use App\Domain\Blog\Presenter\AbstractEditPostPresenter;
use App\Domain\Blog\Presenter\CreatePostPresenterInterface;

class CreatePostPresenter extends AbstractEditPostPresenter implements CreatePostPresenterInterface
{
    protected function getView(): string
    {
        return 'blog/create.html.twig';
    }
}