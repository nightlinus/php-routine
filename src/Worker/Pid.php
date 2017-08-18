<?php
declare(strict_types=1);

/**
 * Date: 18.08.17
 * Time: 12:11
 *
 * @package  php-routine
 * @author   nightlinus <m.a.ogarkov@gmail.com>
 */

namespace nightlinus\PhpRoutines\Worker;

final class Pid implements Id
{
    /**
     * @var int
     */
    private $pid;

    private function __construct(int $pid)
    {
        $this->pid = $pid;
    }

    public static function fromInt(int $pid)
    {
        return new self($pid);
    }

    public function toString(): string
    {
        return (string) $this->pid;
    }
}
