<?php

namespace App\Infrastructure\Representation;

use Symfony\Component\DependencyInjection\ServiceLocator;
use App\Infrastructure\Representation\RepresentationInterface;
use App\Infrastructure\Representation\RepresentationFactoryInterface;

/**
 * Class RepresentationFactory
 * @package App\Infrastructure\Representation
 */
class RepresentationFactory implements RepresentationFactoryInterface
{
    /**
     * @var ServiceLocator
     */
    private ServiceLocator $serviceLocator;

    /**
     * RepresentationFactory constructor.
     * @param ServiceLocator $serviceLocator
     */
    public function __construct(ServiceLocator $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * @inheritDoc
     */
    public function create(string $paginator): RepresentationInterface
    {
        $representation = $this->serviceLocator->get(RepresentationInterface::class);
        return $representation->setPaginator($this->serviceLocator->get($paginator));
    }
}