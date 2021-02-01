<?php

namespace App\Controller;

use App\Entity\Post;
use Twig\Environment;
use App\Entity\Comment;
use App\Handler\PostHandler;
use App\Handler\CommentHandler;
use App\Paginator\PostPaginator;
use App\Security\Voter\PostVoter;
use App\Responder\ReadPostResponder;
use App\Responder\CreatePostResponder;
use App\Responder\UpdatePostResponder;
use App\Responder\ListingPostsResponder;
use App\Responder\RedirectReadPostResponder;
use App\Presenter\ReadPostPresenterInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Responder\RedirectCreatePostResponder;
use App\Responder\RedirectUpdatePostResponder;
use Symfony\Component\HttpFoundation\Response;
use App\Presenter\CreatePostPresenterInterface;
use App\Presenter\UpdatePostPresenterInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Presenter\ListingPostsPresenterInterface;
use App\Representation\RepresentationFactoryInterface;

class BlogController
{
    use AuthorizationTrait;

    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }


    /**
     * @Route("/", name="blog")
     */
    public function index(
        Request $request,
        RepresentationFactoryInterface $representationFactory,
        ListingPostsPresenterInterface $presenter
    ): Response {
        $representation = $representationFactory->create(PostPaginator::class)->handleRequest($request);

        return $presenter->present(new ListingPostsResponder($representation->paginate()));
    }

    /**
     * @Route("/article-{id}", name="blog_read")
     */
    public function read(
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

    /**
     * @Route("/publier-article", name="blog_create")
     */
    public function create(
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

    /**
     * @Route("/modifier-article/{id}", name="blog_update")
     */
    public function update(
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
