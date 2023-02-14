<?php

namespace Tochka\JsonRpc\Standard\Support;

use Illuminate\Container\Container;
use Tochka\JsonRpc\Standard\Contracts\MiddlewareInterface;
use Tochka\JsonRpc\Standard\Contracts\MiddlewareRegistryInterface;
use Tochka\JsonRpc\Standard\Exceptions\InternalErrorException;

/**
 * @psalm-api
 */
class MiddlewareRegistry implements MiddlewareRegistryInterface
{
    /** @var array<string, array<MiddlewareInterface>> */
    private array $middleware = [];
    private Container $container;

    /**
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function addMiddlewaresFromConfig(string $groupName, array $middlewareConfig): void
    {
        /** @psalm-suppress MixedAssignment */
        foreach ($middlewareConfig as $key => $value) {
            if (is_string($value)) {
                $this->middleware[$groupName][] = $this->instantiateMiddleware($value);
            } elseif (is_string($key) && is_array($value)) {
                $this->middleware[$groupName][] = $this->instantiateMiddleware($key, $value);
            }
        }
    }

    public function getMiddleware(string $groupName, ?string $instanceOf = null): array
    {
        if (!array_key_exists($groupName, $this->middleware)) {
            return [];
        }

        if ($instanceOf === null) {
            return $this->middleware[$groupName];
        }

        return array_filter(
            $this->middleware[$groupName],
            function (MiddlewareInterface $middleware) use ($instanceOf) {
                return $middleware instanceof $instanceOf;
            }
        );
    }

    public function prependMiddleware(MiddlewareInterface $middleware, ?string $groupName = null): void
    {
        if ($groupName === null) {
            foreach ($this->middleware as $groupName => $_) {
                $this->prependMiddleware($middleware, $groupName);
            }
        } else {
            array_unshift($this->middleware[$groupName], $middleware);
        }
    }

    public function appendMiddleware(MiddlewareInterface $middleware, ?string $groupName = null): void
    {
        if ($groupName === null) {
            foreach ($this->middleware as $groupName => $_) {
                $this->appendMiddleware($middleware, $groupName);
            }
        } else {
            $this->middleware[$groupName][] = $middleware;
        }
    }

    public function addMiddlewareAfter(
        MiddlewareInterface $middleware,
        string $afterMiddleware,
        ?string $groupName = null
    ): void {
        if ($groupName === null) {
            foreach ($this->middleware as $groupName => $_) {
                $this->addMiddlewareAfter($middleware, $afterMiddleware, $groupName);
            }
        } else {
            $resultedMiddleware = [];
            $find = false;

            foreach ($this->middleware[$groupName] as $middlewareInstance) {
                $resultedMiddleware[] = $middlewareInstance;
                if ($middlewareInstance::class === $afterMiddleware) {
                    $find = true;
                    $resultedMiddleware[] = $middleware;
                }
            }

            if ($find) {
                $this->middleware[$groupName] = $resultedMiddleware;
            } else {
                $this->appendMiddleware($middleware, $groupName);
            }
        }
    }

    public function addMiddlewareBefore(
        MiddlewareInterface $middleware,
        string $beforeMiddleware,
        ?string $groupName = null
    ): void {
        if ($groupName === null) {
            foreach ($this->middleware as $groupName => $_) {
                $this->addMiddlewareBefore($middleware, $beforeMiddleware, $groupName);
            }
        } else {
            $resultedMiddleware = [];
            $find = false;

            foreach ($this->middleware[$groupName] as $middlewareInstance) {
                if (get_class($middlewareInstance) === $beforeMiddleware) {
                    $find = true;
                    $resultedMiddleware[] = $middleware;
                }

                $resultedMiddleware[] = $middlewareInstance;
            }

            if ($find) {
                $this->middleware[$groupName] = $resultedMiddleware;
            } else {
                $this->prependMiddleware($middleware, $groupName);
            }
        }
    }

    private function instantiateMiddleware(string $className, array $params = []): MiddlewareInterface
    {
        try {
            $instance = $this->container->make($className, $params);

            if (!$instance instanceof MiddlewareInterface) {
                throw new \RuntimeException(
                    sprintf('Middleware [%s] must implement [%s]', $className, MiddlewareInterface::class)
                );
            }

            return $instance;
        } catch (\Throwable $e) {
            throw InternalErrorException::from($e);
        }
    }
}
