<?php

namespace Tochka\JsonRpc\Standard\Exceptions\Errors;

use Illuminate\Contracts\Support\Arrayable;

/**
 * @psalm-api
 * @psalm-suppress MissingTemplateParam
 */
class InternalError implements Arrayable
{
    private \Throwable $exception;

    public function __construct(\Throwable $exception)
    {
        $this->exception = $exception;
    }

    public function toArray(): array
    {
        return [
            'exception' => [
                'name' => $this->exception::class,
                'code' => $this->exception->getCode(),
                'message' => $this->exception->getMessage(),
            ],
        ];
    }
}
