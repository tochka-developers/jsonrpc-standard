<?php

namespace Tochka\JsonRpc\Standard\Contracts;

/**
 * @psalm-api
 */
interface MiddlewareRegistryInterface
{
    public function addMiddlewaresFromConfig(string $groupName, array $middlewareConfig): void;

    /**
     * @template T of MiddlewareInterface
     * @param string $groupName
     * @param class-string<T>|null $instanceOf
     * @return array<T>|array<MiddlewareInterface>
     */
    public function getMiddleware(string $groupName, ?string $instanceOf = null): array;

    public function prependMiddleware(MiddlewareInterface $middleware, ?string $groupName = null): void;

    public function appendMiddleware(MiddlewareInterface $middleware, ?string $groupName = null): void;

    /**
     * @param MiddlewareInterface $middleware
     * @param class-string $afterMiddleware
     * @param string|null $groupName
     * @return void
     */
    public function addMiddlewareAfter(
        MiddlewareInterface $middleware,
        string $afterMiddleware,
        ?string $groupName = null,
    ): void;

    /**
     * @param MiddlewareInterface $middleware
     * @param class-string $beforeMiddleware
     * @param string|null $groupName
     * @return void
     */
    public function addMiddlewareBefore(
        MiddlewareInterface $middleware,
        string $beforeMiddleware,
        ?string $groupName = null,
    ): void;
}
