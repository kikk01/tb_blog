<?php

namespace App\Domain\Blog\Presenter;

use App\Domain\Blog\Presenter\AbstractEditPostPresenter;
use App\Domain\Blog\Presenter\UpdatePostPresenterInterface;

class UpdatePostPresenter extends AbstractEditPostPresenter implements UpdatePostPresenterInterface
{
    public function getView(): string
    {
        return 'blog/create.html.twig';
    }
}