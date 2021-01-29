<?php

namespace App\Controller;

use App\DataTransferObject\Credentials;
use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Twig\Environment;

/**
 * Class SecurityController
 * @package App\Controller
 */
class SecurityController
{
    /**
     * @Route("/login", name="security_login")
     */
    public function login(
        AuthenticationUtils $authenticationUtils,
        FormFactoryInterface $formFactory,
        Environment $twig
    ): Response {
        $form = $formFactory->create(LoginType::class, new Credentials($authenticationUtils->getLastUsername()));

        if (null !== $authenticationUtils->getLastAuthenticationError(false)) {
            $form->addError(new FormError($authenticationUtils->getLastAuthenticationError()->getMessage()));
        }
        
        return new Response($twig->render('security/login.html.twig', [
            'form' => $form->createView()
        ]));
    }

        /**
     * @Route("/logout", name="security_logout")
     */
    public function logout() : void
    {

    }
}
