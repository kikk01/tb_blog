<?php
namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class PostFixtures
 * @package App\DataFixtures
 */
class PostFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 100; $i++) {
            $post = (new Post())
                ->setTitle("Article N°" . $i)
                ->setContent("Content" . $i)
                ->setUser($this->getReference(sprintf('user-%d', ($i % 10) + 1)))
                ->setImage('https://picsum.photos/400/300')
            ;
            
            $manager->persist($post);

            for ($j = 1; $j <= rand(5, 15); $j++) {
                $comment = new Comment();
                $comment->setAuthor("Author" . $i);
                $comment->setContent("Commentaire" . $j);
                $comment->setPost($post);

                $manager->persist($comment);
            }
        }

        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies() : array
    {
        return [UserFixtures::class];
    }
}