<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use App\Form\PostType;
use App\Handler\CommentHandler;
use App\Handler\PostHandler;
use App\Security\Voter\PostVoter;
use App\Uploader\UploaderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class BlogController extends AbstractController
{
    /**
     * @Route("/", name="blog")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $limit = $request->get("limit", 10);
        $page = $request->get("page", 1);

        /** @var Paginator $posts */
        $posts = $this->getDoctrine()->getManager()->getRepository(Post::class)->getPaginatedPosts(
            $page,
            $limit
        );

        $pages = ceil($posts->count() / $limit);
        $range = range(
            max($page - 3, 1),
            min($page + 3, $pages)
        );

        return $this->render('blog/index.html.twig', [
            'posts' => $posts,
            'pages' => $pages,
            'page' => $page,
            'limit' => $limit,
            'range' => $range
        ]);
    }

    /**
     * @Route("/article-{id}", name="blog_read")
     * @param Post $post
     * @param Request $request
     * @param CommentHandler $commentHandler
     * @return Response
     */
    public function read(Post $post, Request $request, CommentHandler $commentHandler) : Response
    {
        $comment = new Comment();
        $comment->setPost($post);

        $options = ["validation_groups" => $this->isGranted("ROLE_USER") ? "Default" : ["Default", "anonymous"]];

        if ($commentHandler->handle($request, $comment, $options)) {
            return $this->redirectToRoute("blog_read", ["id" => $post->getId()]);
        }

        return $this->render('blog/read.html.twig', [
            'post' => $post,
            "form" => $commentHandler->createView()
        ]);
    }

    /**
     * @Route("/publier-article", name="blog_create")
     * @param Request $request
     * @param PostHandler $postHandler
     * @return Response
     */
    public function create(
        Request $request,
        PostHandler $postHandler
    ) : Response {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $post = new Post();
        $post->setUser($this->getUser());

        $options = [
            'validation_groups' => ['Default' => 'create']
        ];

        if ($postHandler->handle($request, $post, $options)) {
            return $this->redirectToRoute("blog_read", ["id" => $post->getId()]);
        }

        return $this->render('blog/create.html.twig', [
            'form' => $postHandler->createView()
        ]);
    }

    /**
     * @Route("/modifier-article/{id}", name="blog_update")
     * @param Request $request
     * @param Post $post
     * @param PostHandler $postHandler
     * @return Response
     */
    public function update(
        Post $post,
        Request $request,
        PostHandler $postHandler
    ) : Response {
        $this->denyAccessUnlessGranted(PostVoter::EDIT, $post);

        if ($postHandler->handle($request, $post)) {
            return $this->redirectToRoute("blog_read", ["id" => $post->getId()]);
        }

        return $this->render('blog/update.html.twig', [
            'form' => $postHandler->createView()
        ]);
    }
}
