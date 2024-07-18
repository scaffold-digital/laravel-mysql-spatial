<?php

use PHPUnit\Framework\TestCase;

abstract class BaseTestCase extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    protected function assertException($exceptionName, $exceptionMessage = '', $exceptionCode = 0)
    {
        parent::expectException($exceptionName);
        parent::expectExceptionMessage($exceptionMessage);
        parent::expectExceptionCode($exceptionCode);
    }
}
