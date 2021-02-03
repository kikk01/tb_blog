<?php

namespace App\Domain\User\Controller;

use App\Application\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Domain\User\Handler\RegistrationHandler;
use App\Domain\User\Responder\RegistrationResponder;
use App\Domain\User\Presenter\RegistrationPresenterInterface;

class Registration
{
    public function __invoke(
        Request $request,
        RegistrationHandler $registrationHandler,
        RegistrationPresenterInterface $presenter
    ) : Response {

        if ($registrationHandler->handle($request, New User)) {
            return $presenter->redirect();
        }

        return $presenter->present(new RegistrationResponder($registrationHandler->createView()));
    }
}