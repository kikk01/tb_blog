<?php

namespace App\Domain\Blog\DataTransferObject;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Comment
 * @package App\DataTransfertObject
 */
class Comment
{
    /**
     * @Assert\NotBlank(groups={"anonymous"})
     * @Assert\Length(min=2, groups={"anonymous"})
     */
    private ?string $author = null;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=5)
     */
    private ?string $content = null;

    /**
     * Get the value of author
     */ 
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set the value of author
     *
     * @return  self
     */ 
    public function setAuthor($author): self
    {
        $this->author = $author;

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
    public function setContent($content): self
    {
        $this->content = $content;

        return $this;
    }
}