<?php

namespace App\Controller;

use App\DataTransferObject\Credentials;
use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SecurityController
 * @package App\Controller
 */
class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="security_login")
     * @return Response
     */
    public function login(): Response
    {
        $form = $this->createForm(LoginType::class, new Credentials(''));
        return $this->render('security/login.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
