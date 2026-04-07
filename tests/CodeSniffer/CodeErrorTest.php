<?php

declare(strict_types=1);

namespace BestIt\CodeSniffer;

use Exception;
use PHPUnit\Framework\TestCase;
use Throwable;

class CodeErrorTest extends TestCase
{
    private const CODE = 'ERR_CODE';

    private const MESSAGE = 'Error message';

    private const STACK_POSITION = 7;

    private CodeError $fixture;

    protected function setUp(): void
    {
        $this->fixture = new CodeError(self::CODE, self::MESSAGE, self::STACK_POSITION);
    }

    public function testConstructorSetsCode(): void
    {
        static::assertSame(self::CODE, $this->fixture->getCode());
    }

    public function testConstructorSetsMessage(): void
    {
        static::assertSame(self::MESSAGE, $this->fixture->getMessage());
    }

    public function testConstructorSetsStackPosition(): void
    {
        static::assertSame(self::STACK_POSITION, $this->fixture->getStackPosition());
    }

    public function testExtendsCodeWarning(): void
    {
        static::assertInstanceOf(CodeWarning::class, $this->fixture);
    }

    public function testExtendsException(): void
    {
        static::assertInstanceOf(Exception::class, $this->fixture);
    }

    public function testImplementsThrowable(): void
    {
        static::assertInstanceOf(Throwable::class, $this->fixture);
    }
}
