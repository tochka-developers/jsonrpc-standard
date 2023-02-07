<?php

namespace Tochka\JsonRpc\Standard\Contracts;

use Tochka\JsonRpc\Standard\DTO\JsonRpcError;

/**
 * @psalm-api
 */
interface JsonRpcExceptionInterface
{
    public function getJsonRpcError(): JsonRpcError;
}
