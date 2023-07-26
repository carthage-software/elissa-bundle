<?php

declare(strict_types=1);

namespace Carthage\ElissaBundle\EventListener;

use Carthage\ElissaBundle\RequestHandler\MiddlewareRequestHandler;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

final class ControllerEventListener
{
    /** @param MiddlewareInterface[] $middleware */
    public function __construct(
        private readonly iterable $middleware,
    ) {
    }

    public function __invoke(ControllerEvent $event): void
    {
        $controller = $event->getController();
        if (is_array($controller) && $controller[0] instanceof RequestHandlerInterface) {
            $handler = $controller[0];
        } else {
            return;
        }

        foreach ($this->middleware as $middleware) {
            $handler = new MiddlewareRequestHandler($handler, $middleware);
        }

        $event->setController([$handler, 'handle']);
    }
}
