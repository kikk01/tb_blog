<?php

namespace App\Domain\Blog\Controller;

use App\Application\Entity\Post;
use App\Domain\Blog\Handler\PostHandler;
use App\Application\Security\Voter\PostVoter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Domain\Blog\Responder\UpdatePostResponder;
use App\Infrastructure\Controller\AuthorizationTrait;
use App\Domain\Blog\Responder\RedirectUpdatePostResponder;
use App\Domain\Blog\Presenter\UpdatePostPresenterInterface;

class Update
{
    use AuthorizationTrait;

    public function __invoke(
        Post $post,
        Request $request,
        PostHandler $postHandler,
        UpdatePostPresenterInterface $presenter
    ) : Response {
        $this->denyAccessUnlessGranted(PostVoter::EDIT, $post);

        if ($postHandler->handle($request, $post)) {
            return $presenter->redirect(new RedirectUpdatePostResponder($post));
        }

        return $presenter->present(new UpdatePostResponder($postHandler->createView()));
    }
}