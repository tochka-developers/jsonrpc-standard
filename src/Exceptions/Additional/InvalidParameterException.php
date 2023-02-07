<?php

namespace Tochka\JsonRpc\Standard\Exceptions\Additional;

use Tochka\JsonRpc\Standard\Exceptions\Errors\InvalidParameterError;
use Tochka\JsonRpc\Standard\Exceptions\Errors\InvalidParametersError;

/**
 * @psalm-api
 */
class InvalidParameterException extends AdditionalJsonRpcException
{
    private InvalidParameterError $error;

    public function __construct(InvalidParameterError $error, ?\Throwable $previous = null)
    {
        $this->error = $error;

        parent::__construct(self::CODE_INVALID_PARAMETERS, null, new InvalidParametersError([$this->error]), $previous);
    }

    public static function from(
        string $parameterName,
        string $code,
        ?string $message = null,
        array|object|null $meta = null,
        ?\Throwable $previous = null
    ): self {
        return new self(new InvalidParameterError($parameterName, $code, $message, $meta), $previous);
    }

    public function getParameterError(): InvalidParameterError
    {
        return $this->error;
    }
}
