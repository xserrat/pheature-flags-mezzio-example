<?php

declare(strict_types=1);

namespace App\Handler;

use Mezzio\Template\TemplateRendererInterface;
use Pheature\Core\Toggle\Read\Toggle;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class PheaturePageHandlerFactory
{
    public function __invoke(ContainerInterface $container): RequestHandlerInterface
    {
        $template = $container->get(TemplateRendererInterface::class);
        $toggle   = $container->get(Toggle::class);

        return new PheaturePageHandler($template, $toggle);
    }
}
