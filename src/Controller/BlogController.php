<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\Tools\Pagination\Paginator;

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

        return $this->render('index.html.twig', [
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
     * @return Response
     */
    public function read(Post $post, Request $request) : Response
    {
        $comment = new Comment();
        $comment->setPost($post);
        $form = $this->createForm(CommentType::class, $comment)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($comment);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute("blog_read", ["id" => $post->getId()]);
        }
        return $this->render('read.html.twig', [
            'post' => $post,
            "form" => $form->createView()
        ]);
    }
}
