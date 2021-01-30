<?php

namespace App\Representation;

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