<?php

namespace App\Responder;

use App\Representation\RepresentationInterface;

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