<?php
declare(strict_types=1);
/**
 * Date: 17.08.17
 * Time: 23:43
 *
 * @package  php-routine
 * @author   nightlinus <m.a.ogarkov@gmail.com>
 */

namespace nightlinus\PhpRoutines\tests;

use nightlinus\PhpRoutines\PhpRoutines;
use nightlinus\PhpRoutines\Routine;
use PHP_Timer as Timer;
use PHPUnit\Framework\TestCase;

class PhpRoutinesTest extends TestCase
{
    /**
     * @test
     */
    public function it run routines consequently()
    {
        $duration = 10 ** 5;
        $sut = PhpRoutines::forks();

        $routines = [
            Routine::fromCallable('usleep')->withArguments($duration),
            Routine::fromCallable('usleep')->withArguments($duration),
            Routine::fromCallable('usleep')->withArguments($duration),
            Routine::fromCallable('usleep')->withArguments($duration),
        ];


        Timer::start();
        $sut->sequentialRun(...$routines);
        $elapsed = Timer::stop();

        $expectedDuration = 4 * $duration / 10 ** 6;

        $this->assertTrue(
            $elapsed > $expectedDuration,
            "Routines should run consequently, min expected duration is $expectedDuration, actual duration is $elapsed"
        );
    }

    /**
     * @test
     */
    public function it run routines in parallel()
    {
        $duration = 10 ** 5;
        $sut = PhpRoutines::forks();

        $routine = [
            Routine::fromCallable('usleep')->withArguments($duration),
            Routine::fromCallable('usleep')->withArguments($duration),
            Routine::fromCallable('usleep')->withArguments($duration),
            Routine::fromCallable('usleep')->withArguments($duration),
        ];


        Timer::start();
        $sut->parallelRun(...$routine);
        $elapsed = Timer::stop();

        $expectedDuration = 2 * $duration / 10 ** 6;

        $this->assertTrue(
            $elapsed < $expectedDuration,
            "Routines should run in parallel, max expected duration is $expectedDuration, actual duration is $elapsed"
        );
    }

    public function it can set title on master process()
    {
        $sut = PhpRoutines::forks();
        $actual = $sut->named('test');

        $this->assertInstanceOf(PhpRoutines::class, $actual);
    }
}

