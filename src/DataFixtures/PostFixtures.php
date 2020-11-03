<?php
namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PostFixtures extends Fixture 
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 25; $i++) {
            $post = (new Post())
                ->setTitle("Article N°" . $i)
                ->setContent("Content" . $i)
            ;
            
            $manager->persist($post);

            for ($j = 1; $j <= 25; $j++) {
                $comment = (new Comment())
                    ->setAuthor("Author" . $i)
                    ->setContent("Commentaire" . $i)
                    ->setPost($post)
                ;

                $manager->persist($post);
            }
        }

        $manager->flush();
    }
}