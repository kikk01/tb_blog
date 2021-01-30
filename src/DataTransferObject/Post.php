<?php

namespace App\DataTransferObject;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
  * Class Post
  * @package App\TransfertObject
  */
class Post 
{

    /**
     * @Assert\NotBlank
     */
    private ?string $title = null;

    /**
     * @Assert\NotNull(groups={"create"})
     * @Assert\Image
     */
    private ?UploadedFile $image = null;

    /**
     * @Assert\NotBlank
     * @Assert\Length(min=10)
     */
    private ?string $content = null;

    

    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle(?string $title): Post
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of content
     */ 
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */ 
    public function setContent(?string $content): Post
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the value of image
     */ 
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set the value of image
     *
     * @return  self
     */ 
    public function setImage(?UploadedFile $image): Post
    {
        $this->image = $image;

        return $this;
    }
}