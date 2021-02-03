<?php

namespace App\Domain\Blog\Handler;

use App\Domain\Blog\Form\PostType;
use Doctrine\ORM\UnitOfWork;
use App\Domain\Blog\DataTransferObject\Post;
use Doctrine\ORM\EntityManagerInterface;
use App\Infrastructure\Handler\AbstractHandler;

class PostHandler extends AbstractHandler
{
    /**
     * EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @inheritDoc
     */
    protected function getFormType(): string
    {
        return PostType::class;
    }

    /**
     * @inheritDoc
     */
    protected function process($data): void
    {
        if ($this->entityManager->getUnitOfWork()->getEntityState($data) === UnitOfWork::STATE_NEW) {
            $this->entityManager->persist($data);
        }
        $this->entityManager->flush();
    }

    protected function getDataTransferObject(): object
    {
        return new Post();
    }
}
