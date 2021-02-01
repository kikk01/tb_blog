<?php

namespace App\Presenter;

use App\Presenter\AbstractEditPostPresenter;

class CreatePostPresenter extends AbstractEditPostPresenter implements CreatePostPresenterInterface
{
    protected function getView(): string
    {
        return 'blog/create.html.twig';
    }
}