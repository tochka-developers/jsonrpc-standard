<?php

namespace Tochka\JsonRpc\Standard\Helpers;

use Illuminate\Contracts\Support\Arrayable;

trait PrepareValue
{
    /**
     * @template T
     * @param T $value
     * @return array|T
     */
    protected function prepareValueForArrayable(mixed $value): mixed
    {
        if ($value instanceof Arrayable) {
            /** @var array */
            return $value->toArray();
        } elseif ($value instanceof \JsonSerializable) {
            /** @var array */
            return $value->jsonSerialize();
        }

        return $value;
    }

    /**
     * @template T
     * @param T $value
     * @return array|T
     */
    protected function prepareValueForJsonable(mixed $value): mixed
    {
        if ($value instanceof \JsonSerializable) {
            /** @var array */
            return $value->jsonSerialize();
        } elseif ($value instanceof Arrayable) {
            /** @var array */
            return $value->toArray();
        }

        return $value;
    }
}
