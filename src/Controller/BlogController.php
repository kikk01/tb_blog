<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/", name="blog")
     */
    public function index(Request $request): Response
    {
        $total = $this->getDoctrine()->getManager()->getRepository(Post::class)->count([]);
        $posts = $this->getDoctrine()->getManager()->getRepository(Post::class)->getPaginatedPosts(
            $request->get("page", 1), 10
        );

        $pages = ceil($total / 10);
        return $this->render('index.html.twig', [
            'posts' => $posts,
            'pages' => $pages
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
