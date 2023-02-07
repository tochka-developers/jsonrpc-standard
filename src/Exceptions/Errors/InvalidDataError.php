<?php

namespace Tochka\JsonRpc\Standard\Exceptions\Errors;

use Illuminate\Contracts\Support\Arrayable;

/**
 * @psalm-api
 * @psalm-suppress MissingTemplateParam
 */
class InvalidDataError implements Arrayable
{
    private string $field;
    private string $message;

    public function __construct(string $field, string $message)
    {
        $this->field = $field;
        $this->message = $message;
    }

    public function toArray(): array
    {
        return [
            'field' => $this->field,
            'message' => $this->message
        ];
    }
}
