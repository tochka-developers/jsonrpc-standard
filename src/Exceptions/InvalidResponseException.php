<?php

namespace Tochka\JsonRpc\Standard\Exceptions;

use Tochka\JsonRpc\Standard\Exceptions\Errors\InvalidDataError;

/**
 * @psalm-api
 */
class InvalidResponseException extends JsonRpcException
{
    public function __construct(
        ?string $message = null,
        ?InvalidDataError $error = null,
        ?\Throwable $previous = null
    ) {
        parent::__construct(self::CODE_INVALID_RESPONSE, $message, $error, $previous);
    }

    public static function from(string $field, string $message, ?\Throwable $previous = null): self
    {
        return new self(null, new InvalidDataError($field, $message), $previous);
    }
}
