<?php

declare(strict_types=1);

namespace BestIt\CodeSniffer;

use Exception;
use PHPUnit\Framework\TestCase;
use Throwable;

class CodeWarningTest extends TestCase
{
    private const CODE = 'MY_CODE';

    private const MESSAGE = 'My message';

    private const STACK_POSITION = 42;

    private CodeWarning $fixture;

    protected function setUp(): void
    {
        $this->fixture = new CodeWarning(self::CODE, self::MESSAGE, self::STACK_POSITION);
    }

    public function testConstructorSetsCodeAsString(): void
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

    public function testExtendsException(): void
    {
        static::assertInstanceOf(Exception::class, $this->fixture);
    }

    public function testGetPayloadReturnsEmptyArrayByDefault(): void
    {
        static::assertSame([], $this->fixture->getPayload());
    }

    public function testGetTokenReturnsNullByDefault(): void
    {
        static::assertNull($this->fixture->getToken());
    }

    public function testImplementsThrowable(): void
    {
        static::assertInstanceOf(Throwable::class, $this->fixture);
    }

    public function testIsFixableDoesNotChangeWhenNullPassed(): void
    {
        $this->fixture->isFixable(true);

        $oldStatus = $this->fixture->isFixable(null);

        static::assertTrue($oldStatus);
        static::assertTrue($this->fixture->isFixable());
    }

    public function testIsFixableReturnsFalseByDefault(): void
    {
        static::assertFalse($this->fixture->isFixable());
    }

    public function testIsFixableReturnsOldStatusWhenSettingNew(): void
    {
        $oldStatus = $this->fixture->isFixable(true);

        static::assertFalse($oldStatus);
        static::assertTrue($this->fixture->isFixable());
    }

    public function testSetPayloadStoresAndReturnsSelf(): void
    {
        $payload = ['foo' => 'bar'];
        $result = $this->fixture->setPayload($payload);

        static::assertSame($this->fixture, $result);
        static::assertSame($payload, $this->fixture->getPayload());
    }

    public function testSetTokenStoresAndReturnsSelf(): void
    {
        $token = ['content' => 'foo', 'type' => 'T_STRING'];
        $result = $this->fixture->setToken($token);

        static::assertSame($this->fixture, $result);
        static::assertSame($token, $this->fixture->getToken());
    }
}
