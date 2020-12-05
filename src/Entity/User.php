<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @var int|null
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @var string|null
     * @ORM\Column(unique=true)
     */
    private ?string $email = null;

    /**
     * @var string|null
     * @ORM\Column()
     */
    private ?string $password = null;

    /**
     * @var string|null
     * @ORM\Column(unique=true)
     */
    private ?string $pseudo = null;

    /**
     * @var DateTimeImmutable
     * @ORM\Column(type='datetime_immutable')
     */
    private DateTimeImmutable $registratedAt;

    /**
     * User constructor
     * @throws \Exception
     */
    public function __construct()
    {
        $this->registratedAt = new DateTimeImmutable();
    }

    /**
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of email
     *
     * @return  string|null
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @param  string|null  $email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    
    /**
     * Get the value of password
     *
     * @return  string|null
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @param  string|null  $password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of pseudo
     *
     * @return  string|null
     */ 
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * Set the value of pseudo
     *
     * @param  string|null  $pseudo
     *
     * @return  self
     */ 
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get the value of registratedAt
     *
     * @return  DateTimeImmutable
     */ 
    public function getRegistratedAt()
    {
        return $this->registratedAt;
    }

    /**
     * Set the value of registratedAt
     *
     * @param  DateTimeImmutable  $registratedAt
     *
     * @return  self
     */ 
    public function setRegistratedAt(DateTimeImmutable $registratedAt)
    {
        $this->registratedAt = $registratedAt;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    /**
     * @inheritDoc
     */
    public function getSalt(){}

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials() {}
}
