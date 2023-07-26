<?php

declare(strict_types=1);

namespace Carthage\ElissaBundle\RequestHandler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class MiddlewareRequestHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly RequestHandlerInterface $handler,
        private readonly MiddlewareInterface $middleware,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->middleware->process($request, $this->handler);
    }
}
