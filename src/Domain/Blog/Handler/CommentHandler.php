<?php

namespace App\Domain\Blog\Handler;

use App\Domain\Blog\Form\CommentType;
use App\Domain\Blog\DataTransferObject\Comment;
use Doctrine\ORM\EntityManagerInterface;
use App\Infrastructure\Handler\AbstractHandler;

/**
 * Class CommentHandler
 * @package App/Handler
 */
class CommentHandler extends AbstractHandler
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    protected function getFormType(): string
    {
        return CommentType::class;
    }

    protected function process($data): void
    {
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    protected function getDataTransferObject(): object
    {
        return new Comment();
    }
}
