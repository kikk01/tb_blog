<?php

namespace App\DataTransferObject;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Credentials
 * @package  App\DataTransferObject
 */
class Credentials
{
    /**
     * @var string|null
     * @Assert\NotBlank
     */
    private ?string $username = null;

    /**
     * @var string|null
     * @Assert\NotBlank
     */
    private ?string $password = null;

    public function __construct(?string $username = null)
    {
        $this->username = $username;
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
     * Get the value of username
     *
     * @return  string|null
     */ 
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @param  string|null  $username
     *
     * @return  self
     */ 
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }
}