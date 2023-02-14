<?php

namespace Tochka\JsonRpc\Standard\Tests\Units;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

abstract class DefaultTestCase extends TestCase
{
    use MockeryPHPUnitIntegration;
}
