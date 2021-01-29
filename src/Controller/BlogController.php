<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\Comment;
use App\Entity\Post;
use App\Handler\CommentHandler;
use App\Handler\PostHandler;
use App\Security\Voter\PostVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\Tools\Pagination\Paginator;
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
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $limit = $request->get("limit", 10);
        $page = $request->get("page", 1);

        /** @var Paginator $posts */
        $posts = $entityManager->getRepository(Post::class)->getPaginatedPosts(
            $page,
            $limit
        );

        $pages = ceil($posts->count() / $limit);
        $range = range(
            max($page - 3, 1),
            min($page + 3, $pages)
        );

        return new Response($this->twig->render('blog/index.html.twig', [
            'posts' => $posts,
            'pages' => $pages,
            'page' => $page,
            'limit' => $limit,
            'range' => $range
        ]));
    }

    /**
     * @Route("/article-{id}", name="blog_read")
     * @param Post $post
     * @param Request $request
     * @param CommentHandler $commentHandler
     * @return Response
     */
    public function read(
        Post $post,
        Request $request,
        CommentHandler $commentHandler,
        UrlGeneratorInterface $urlGenerator
    ) : Response {

        $comment = new Comment();
        $comment->setPost($post);

        $options = ["validation_groups" => $this->isGranted("ROLE_USER") ? "Default" : ["Default", "anonymous"]];

        if ($commentHandler->handle($request, $comment, $options)) {
            return new RedirectResponse($urlGenerator->generate("blog_read", ["id" => $post->getId()]));
        }

        return new Response($this->twig->render('blog/read.html.twig', [
            'post' => $post,
            "form" => $commentHandler->createView()
        ]));
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
