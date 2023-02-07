<?php

namespace Tochka\JsonRpc\Standard\Exceptions\Errors;

use Illuminate\Contracts\Support\Arrayable;

/**
 * @psalm-api
 * @psalm-suppress MissingTemplateParam
 */
class InvalidParametersError implements Arrayable
{
    /**
     * @var array<InvalidParameterError>
     */
    private array $invalidParameterErrors;

    /**
     * @param array<InvalidParameterError> $invalidParameterErrors
     */
    public function __construct(array $invalidParameterErrors)
    {
        $this->invalidParameterErrors = $invalidParameterErrors;
    }

    public function getParameterErrors(): array
    {
        return $this->invalidParameterErrors;
    }

    public function toArray(): array
    {
        return [
            'errors' => array_map(fn (InvalidParameterError $error) => $error->toArray(), $this->invalidParameterErrors)
        ];
    }
}
