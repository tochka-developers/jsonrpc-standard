<?php

namespace Tochka\JsonRpc\Standard\Exceptions\Errors;

use Illuminate\Contracts\Support\Arrayable;

/**
 * @psalm-api
 * @psalm-suppress MissingTemplateParam
 */
class InvalidParameterError implements Arrayable
{
    public const CODE_PARAMETER_REQUIRED = 'required';
    public const CODE_PARAMETER_NOT_NULLABLE = 'not_nullable';
    public const CODE_PARAMETER_INCORRECT_TYPE = 'incorrect_type';
    public const CODE_INCORRECT_VALUE = 'incorrect_value';

    public const DEFAULT_MESSAGES = [
        self::CODE_PARAMETER_REQUIRED => 'The field is required, but not present',
        self::CODE_PARAMETER_NOT_NULLABLE => 'The field is cannot be null',
        self::CODE_PARAMETER_INCORRECT_TYPE => 'Field type incorrect',
        self::CODE_INCORRECT_VALUE => 'Invalid value for field',
    ];

    private string $parameterName;
    private string $code;
    private string $message;
    private array|object|null $meta;

    public function __construct(
        string $parameterName,
        string $code,
        ?string $message = null,
        array|object|null $meta = null
    ) {
        $this->parameterName = $parameterName;
        $this->code = $code;
        $this->message = $message ?? self::DEFAULT_MESSAGES[$code] ?? 'Unknown error';
        $this->meta = $meta;
    }

    public function toArray(): array
    {
        $result = [
            'object_name' => $this->parameterName,
            'code' => $this->code,
            'message' => $this->message
        ];

        if ($this->meta !== null) {
            $result['meta'] = $this->meta;
        }

        return $result;
    }
}
