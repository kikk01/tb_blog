<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Handler\RegistrationHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class RegistrationController
 * @package App\Controller
 */
class RegistrationController extends AbstractController
{
    /**
     * @Route("/inscription", name="registration")
     */
    public function __invoke(
        Request $request,
        RegistrationHandler $registrationHandler
    ) : Response {

        if ($registrationHandler->handle($request, New User)) {
            return $this->redirectToRoute('security_login');
        }

        return $this->render('registration.html.twig', [
            'form' => $registrationHandler->createView()
        ]);
    }
}