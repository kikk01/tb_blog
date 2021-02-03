<?php

namespace App\Infrastructure\Representation;

use App\Infrastructure\Representation\RepresentationInterface;

/**
 * Interface RepresentationFactoryInterface
 * @package App\Infrastructure\Representation
 */
interface RepresentationFactoryInterface
{
    /**
     * @param string $paginator
     * @return RepresentationInterface
     */
    public function create(string $paginator): RepresentationInterface;
}