<?php

namespace Prezly\Slate\Tests;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function loadFixture(string $fixture): string
    {
        return file_get_contents(__DIR__ . "/fixtures/$fixture");
    }
}