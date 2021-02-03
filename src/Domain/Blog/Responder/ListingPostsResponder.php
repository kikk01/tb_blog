<?php

namespace App\Domain\Blog\Responder;

use App\Infrastructure\Representation\RepresentationInterface;

class ListingPostsResponder
{
    private RepresentationInterface $representation;

    public function __construct(RepresentationInterface $representation)
    {
        $this->representation = $representation;
    }

    public function getRepresentation(): RepresentationInterface
    {
        return $this->representation;
    }
}