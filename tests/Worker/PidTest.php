<?php
declare(strict_types=1);
/**
 * Date: 18.08.17
 * Time: 12:12
 *
 * @package  php-routine
 * @author   nightlinus <m.a.ogarkov@gmail.com>
 */

namespace nightlinus\PhpRoutines\tests\Worker;

use nightlinus\PhpRoutines\Worker\Pid;
use PHPUnit\Framework\TestCase;

class PidTest extends TestCase
{
    /** @test */
    public function it can be converted to string()
    {
        $sut = Pid::fromInt(123);

        $this->assertSame('123', $sut->toString());
    }
}
