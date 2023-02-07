<?php

namespace Tochka\JsonRpc\Standard\Exceptions;

use Tochka\JsonRpc\Standard\Exceptions\Errors\InternalError;

/**
 * @psalm-api
 */
class InternalErrorException extends JsonRpcException
{
    public function __construct(?string $message = null, InternalError $error = null, ?\Throwable $previous = null)
    {
        parent::__construct(self::CODE_INTERNAL_ERROR, $message, $error, $previous);
    }

    public static function from(\Throwable $exception): self
    {
        return new self(null, new InternalError($exception), $exception);
    }
}
