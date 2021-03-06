<?php

namespace App\Infrastructure\Twig;

use Twig\TwigFilter;
use Twig\Extension\AbstractExtension;
use App\Infrastructure\Representation\RepresentationInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RepresentationExtension extends AbstractExtension
{
    /**
     * @var UrlGeneratorInterface
     */
    private UrlGeneratorInterface $urlGenerator;

    /**
     * RepresentationExtension constructor.
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('path', [$this, 'path'])
        ];
    }

    public function path(
        RepresentationInterface $representation,
        ?int $page = null,
        ?int $limit = null,
        ?string $field = null,
        ?string $order = null
    ): string {
        return $this->urlGenerator->generate($representation->getRoute(), array_merge(
            $representation->getRouteParams(),
            [
                "page" => $page ?? $representation->getPage(),
                "limit" => $limit ?? $representation->getLimit(),
                "field" => $field ?? $representation->getField(),
                "order" => $order ?? $representation->getOrder()
            ]
        ));
    }

}