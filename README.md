# Elissa Bundle - PSR-7 & PSR-15 Made Easy!

Elissa Bundle by Carthage brings out-of-the-box PSR-7 and PSR-15 support to your Symfony project.

The package allows developers to write PSR-15 handlers and middleware, which are auto-tagged and ready to use as controllers.

It also provides ready access to all PSR-7 factories, and enables seamless integration of middleware from third-party vendor packages.

## Installation 🚀

Install the Elissa Bundle using Composer with the following command:

```bash
composer require carthage/elissa-bundle
```

## Enabling the Bundle 🎚

To enable the bundle in your Symfony project, add the following line in the `config/bundles.php` file:

```php
return [
    //...
    Carthage\ElissaBundle\ElissaBundle::class => ['all' => true],
    //...
];
```

## Usage 💼

### PSR-7 Factories 🏭

The Elissa Bundle comes with autowired and pre-configured PSR-7 factories. You can conveniently create PSR-7 objects in your services without any extra configuration.

```php
<?php

declare(strict_types=1);

namespace App\Service;

use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;

final class MyService
{
    public function __construct(
        private StreamFactoryInterface $streamFactory,
        private ResponseFactoryInterface $responseFactory,
        private RequestFactoryInterface $requestFactory,
        private ServerRequestFactoryInterface $serverRequestFactory,
        private UriFactoryInterface $uriFactory,
        private UploadedFileFactoryInterface $uploadedFileFactory,
    ) {}
}
```

### PSR-15 Handlers 🎛

After installing and enabling the Elissa Bundle, writing PSR-15 handlers becomes a breeze. The handlers will automatically function as controllers in your Symfony project.

```php
<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Component\Routing\Annotation\Route;

final class HomeHandler implements RequestHandlerInterface
{
    public function __construct(
        private StreamFactoryInterface $streamFactory,
        private ResponseFactoryInterface $responseFactory,
    ) {}

    #[Route('/', name: 'home')]
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $body = $this->streamFactory->createStream('Hello World!');

        return $this->responseFactory->createResponse(200)
            ->withBody($body);
    }
}
```

### PSR-15 Middleware 🛠

Just like handlers, you can write PSR-15 middleware, and they will automatically function.

```php
<?php

declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class MadeWithMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);
        
        return $response->withHeader('X-Made-With', 'Love');
    }
}
```

### Configurations ⚙

The Elissa Bundle is designed to minimize configuration, but if you need to register additional PSR-15 middlewares from third-party vendors, you can use the `elissa.middleware` service tag.

```yaml
# config/services.yaml

services:
    Some\External\ServiceMiddleware:
        tags:
            - { name: elissa.middleware }
```

## Code Of Conduct 🤝

Our community is guided by a Code of Conduct, and we expect all contributors to respect it. See the [`CODE_OF_CONDUCT`](./CODE_OF_CONDUCT.md) for more details.

## Contributing 🎁

The Elissa Bundle thrives on contributions from the open-source community. We value every contribution, no matter how small.

## License 📜

The Elissa Bundle is distributed under the MIT License. See [`LICENSE`](./LICENSE) for more information.

---

We hope you enjoy using the Elissa Bundle! For any queries or suggestions, don't hesitate to open an issue or submit a pull request. Happy coding!
