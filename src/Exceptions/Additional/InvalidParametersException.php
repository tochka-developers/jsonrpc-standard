<?php

namespace Tochka\JsonRpc\Standard\Exceptions\Additional;

use Tochka\JsonRpc\Standard\Exceptions\Errors\InvalidParameterError;
use Tochka\JsonRpc\Standard\Exceptions\Errors\InvalidParametersError;

/**
 * @psalm-api
 */
class InvalidParametersException extends AdditionalJsonRpcException
{
    private InvalidParametersError $errors;

    public function __construct(InvalidParametersError $errors, ?\Throwable $previous = null)
    {
        $this->errors = $errors;

        parent::__construct(self::CODE_INVALID_PARAMETERS, null, $this->errors, $previous);
    }

    /**
     * @param array<InvalidParameterError> $errors
     * @param \Throwable|null $previous
     * @return self
     */
    public static function from(array $errors, ?\Throwable $previous = null): self
    {
        return new self(new InvalidParametersError($errors), $previous);
    }

    public function getParametersError(): InvalidParametersError
    {
        return $this->errors;
    }
}
