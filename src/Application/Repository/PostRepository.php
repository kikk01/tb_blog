<?php

namespace App\Application\Repository;

use App\Application\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * return all posts with comments
     *
     * @return array
     */
    public function getAllPosts(): array
    {
        return $this->createQueryBuilder("p")
            ->addSelect("c")
            ->join("p.comments", "c")
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * return paginated posts with comments
     *
     * @param integer $page
     * @param integer $limit
     * @return Paginator
     */
    public function getPaginatedPosts(): QueryBuilder
    {
        return $this->createQueryBuilder("p");
    }
}
