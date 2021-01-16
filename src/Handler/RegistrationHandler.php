<?php

namespace App\Handler;

use App\DataTransferObject\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;

class RegistrationHandler extends AbstractHandler
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    protected function getDataTransferObject(): User
    {
        return new User;
    }

    protected function getFormType(): string
    {
        return UserType::class;
    }

    protected function process($data): void
    {
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
}