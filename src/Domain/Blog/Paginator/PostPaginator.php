<?php

namespace App\Domain\Blog\Paginator;

use App\Application\Repository\PostRepository;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Infrastructure\Representation\AbstractPaginator;
use App\Infrastructure\Representation\RepresentationBuilderInterface;

class PostPaginator extends AbstractPaginator
{
    /**
     * @var PostRepository
     */
    private PostRepository $postRepository;

    /**
     * PostPaginator constructor.
     * @param PostRepository $postRepository
     */
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @inheritDoc
     */
    public function build(RepresentationBuilderInterface $builder, array $options): void
    {
        $builder->setQueryBuilder($this->postRepository->getPaginatedPosts());
    }

    /**
     * @inheritDoc
     */
    public function configure(OptionsResolver $resolver): void
    {
        $resolver->setDefault("route", "blog");
        $resolver->setDefault("field", "p.publishedAt");
        $resolver->setDefault("order", "desc");
    }
}