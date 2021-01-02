<?php

namespace App\Handler;

use App\DataTransferObject\Comment;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;

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
