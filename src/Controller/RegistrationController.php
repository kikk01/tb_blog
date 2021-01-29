<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Handler\RegistrationHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Twig\Environment;

/**
 * Class RegistrationController
 * @package App\Controller
 */
class RegistrationController
{
    /**
     * @Route("/inscription", name="registration")
     */
    public function __invoke(
        Request $request,
        RegistrationHandler $registrationHandler,
        Environment $twig,
        UrlGeneratorInterface $urlGenerator
    ) : Response {

        if ($registrationHandler->handle($request, New User)) {
            return new RedirectResponse($urlGenerator->generate('security_login'));
        }

        return new Response ($twig->render('registration.html.twig', [
            'form' => $registrationHandler->createView()
        ]));
    }
}