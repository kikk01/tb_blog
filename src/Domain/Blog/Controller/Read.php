<?php

namespace App\Domain\Blog\Controller;

use App\Application\Entity\Post;
use App\Application\Entity\Comment;
use App\Domain\Blog\Handler\CommentHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Domain\Blog\Responder\ReadPostResponder;
use App\Infrastructure\Controller\AuthorizationTrait;
use App\Domain\Blog\Responder\RedirectReadPostResponder;
use App\Domain\Blog\Presenter\ReadPostPresenterInterface;

class Read
{
    use AuthorizationTrait;

    public function __invoke(
        Post $post,
        Request $request,
        CommentHandler $commentHandler,
        ReadPostPresenterInterface $presenter
    ) : Response {

        $comment = new Comment();
        $comment->setPost($post);

        $options = ["validation_groups" => $this->isGranted("ROLE_USER") ? "Default" : ["Default", "anonymous"]];

        if ($commentHandler->handle($request, $comment, $options)) {
            return $presenter->redirect(new RedirectReadPostResponder($post));
        }

        return $presenter->present(new ReadPostResponder(
            $post,
            $commentHandler->createView()
        ));
    }
}