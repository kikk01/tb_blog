<?php

namespace App\Domain\Blog\Controller;

use App\Application\Entity\Post;
use App\Domain\Blog\Handler\PostHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Domain\Blog\Responder\CreatePostResponder;
use App\Infrastructure\Controller\AuthorizationTrait;
use App\Domain\Blog\Responder\RedirectCreatePostResponder;
use App\Domain\Blog\Presenter\CreatePostPresenterInterface;

class Create
{
    use AuthorizationTrait;

    public function __invoke(
        Request $request,
        PostHandler $postHandler,
        CreatePostPresenterInterface $presenter
    ) : Response {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $post = new Post();

        $options = [
            'validation_groups' => ['Default' => 'create']
        ];

        if ($postHandler->handle($request, $post, $options)) {
            return $presenter->redirect(new RedirectCreatePostResponder($post));
        }

        return $presenter->present(new CreatePostResponder($postHandler->createView()));
    }
}
