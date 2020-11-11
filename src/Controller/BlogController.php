<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/", name="blog")
     */
    public function index(): Response
    {
        $posts = $this->getDoctrine()->getManager()->getRepository(Post::class)->getAllPosts();

        return $this->render('index.html.twig', ['posts' => $posts]);
    }

    /**
     * @Route("/post/{id}", name="blog_read")
     *
     * @return Response
     */
    public function read(Post $post) : Response
    {
        return $this->render('read.html.twig', ['post' => $post]);
    }
}
