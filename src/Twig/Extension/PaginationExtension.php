<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\PaginationExtensionRuntime;
use http\Url;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class PaginationExtension extends AbstractExtension
{
    private ?Request $request;

    public function __construct(
        private RequestStack    $stack,
        private RouterInterface $router
    )
    {
        $this->request = $this->stack->getCurrentRequest();
    }

    public function getFilters(): array
    {
        return [];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('currentRouteWithParam', [$this, 'currentRouteWithParam']),
        ];
    }

    public function currentRouteWithParam(array $paramValues): string
    {
        $route = $this->request->attributes->get('_route');
        $queryParams = array_merge($this->request->query->all(), $paramValues);

        return $this->router->generate($route, $queryParams);
    }
}
