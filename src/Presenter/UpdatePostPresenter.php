<?php

namespace App\Presenter;

use App\Presenter\AbstractEditPostPresenter;

class UpdatePostPresenter extends AbstractEditPostPresenter implements UpdatePostPresenterInterface
{
    public function getView(): string
    {
        return 'blog/create.html.twig';
    }
}