<?php

namespace App\DataTransferObject;

use App\Validator\ {
    UniquePseudo,
    UniqueEmail
};
use Symfony\Component\Validator\Constraints as Assert;

class User
{
    /**
     * @Assert\Email
     * @Assert\NotBlank
     * @UniqueEmail
     */
    private ?string $email = null;

    /**
     * @Assert\NotBlank
     * @Assert\Length(min=8)
     */
    private ?string $password = null;

    /**
     * @Assert\NotBlank
     * @UniquePseudo
     */
    private ?string $pseudo = null;

    

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of pseudo
     */ 
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * Set the value of pseudo
     *
     * @return  self
     */ 
    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }
}