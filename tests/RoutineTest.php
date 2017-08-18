<?php
declare(strict_types=1);
/**
 * Date: 18.08.17
 * Time: 11:18
 *
 * @package  php-routine
 * @author   nightlinus <m.a.ogarkov@gmail.com>
 */

namespace nightlinus\PhpRoutines\tests;

use nightlinus\PhpRoutines\Routine;
use PHPUnit\Framework\TestCase;

class RoutineTest extends TestCase
{
    /** @test */
    public function it can be created from callable()
    {
        $sut = Routine::fromCallable('phpversion');

        $this->assertInstanceOf(Routine::class, $sut);
    }

    /** @test */
    public function it can be run()
    {
        $argsTest = function () {
            $this->assertTrue(true);
        };

        $sut = Routine::fromCallable($argsTest);

        $sut->run();
    }

    /** @test */
    public function it accept arguments for future run()
    {
        $expectedArguments = [ 'test', 'variadic', 'arguments' ];
        $argsTest = function (...$arguments) use ($expectedArguments) {
            $this->assertEquals($expectedArguments, $arguments);
        };

        $sut = Routine::fromCallable($argsTest)->withArguments(...$expectedArguments);

        $sut->run();
    }

    /** @test */
    public function routine can be named()
    {
        $name = 'future::name';
        $sut = Routine::fromCallable('phpversion')->named($name);

        $this->assertEquals($name, $sut->name());
    }
}
