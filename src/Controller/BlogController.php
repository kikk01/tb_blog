<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\Comment;
use App\Entity\Post;
use App\Handler\CommentHandler;
use App\Handler\PostHandler;
use App\Paginator\PostPaginator;
use App\Presenter\ListingPostsPresenterInterface;
use App\Presenter\PresenterInterface;
use App\Presenter\ReadPostPresenterInterface;
use App\Representation\RepresentationFactoryInterface;
use App\Responder\ListingPostsResponder;
use App\Responder\ReadPostResponder;
use App\Responder\RedirectReadPostResponder;
use App\Security\Voter\PostVoter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

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
        UrlGeneratorInterface $urlGenerator
    ) : Response {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $post = new Post();

        $options = [
            'validation_groups' => ['Default' => 'create']
        ];

        if ($postHandler->handle($request, $post, $options)) {
            return new RedirectResponse($urlGenerator->generate("blog_read", ["id" => $post->getId()]));
        }

        return new Response($this->twig->render('blog/create.html.twig', [
            'form' => $postHandler->createView()
        ]));
    }

    /**
     * @Route("/modifier-article/{id}", name="blog_update")
     */
    public function update(
        Post $post,
        Request $request,
        PostHandler $postHandler,
        UrlGeneratorInterface $urlGenerator
    ) : Response {
        $this->denyAccessUnlessGranted(PostVoter::EDIT, $post);

        if ($postHandler->handle($request, $post)) {
            return new RedirectResponse($urlGenerator->generate("blog_read", ["id" => $post->getId()]));
        }

        return new Response($this->twig->render('blog/update.html.twig', [
            'form' => $postHandler->createView()
        ]));
    }
}
