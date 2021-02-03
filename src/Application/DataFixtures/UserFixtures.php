<?php
namespace App\Application\DataFixtures;

use App\Application\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserFixtures
 * @package App\DataFixtures
 */
class UserFixtures extends Fixture
{
    private UserPasswordEncoderInterface $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }


    /**
     * @inheritDoc
     *
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 10; $i++) {
            $user = new User();
            $user->setEmail(sprintf("email+%d@email.com", $i));
            $user->setPseudo(sprintf('pseudo+%d', $i));
            $user->setPassword($this->userPasswordEncoder->encodePassword($user, 'password'));
            $manager->persist($user);
            $this->setReference(sprintf('user-%d', $i), $user);
        }
        $manager->flush();
    }
}