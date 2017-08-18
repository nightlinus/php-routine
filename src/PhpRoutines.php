<?php
declare(strict_types=1);

/**
 * Date: 17.08.17
 * Time: 17:35
 *
 * @package  php-routine
 * @author   nightlinus <m.a.ogarkov@gmail.com>
 */

namespace nightlinus\PhpRoutines;

use nightlinus\PhpRoutines\Strategy\Fork;
use nightlinus\PhpRoutines\Strategy\Strategy;

final class PhpRoutines
{
    /**
     * @var Strategy
     */
    private $strategy;

    public function __construct(Strategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public static function forks(): self
    {
        return new self(new Fork());
    }

    /**
     * Runs routine, wait for finish, run next etc…
     *
     * @param Routine[] ...$routines
     */
    public function sequentialRun(Routine ...$routines)
    {
        foreach ($routines as $routine) {
            $id = $this->strategy->createWorker($routine);
            $this->strategy->waitWorker($id);
        }
    }


    /**
     * Runs routines without waiting previous to finish
     *
     * @param Routine[] ...$routines
     */
    public function parallelRun(Routine ...$routines)
    {
        $ids = [];
        foreach ($routines as $routine) {
            $ids[] = $this->strategy->createWorker($routine);
        }

        foreach ($ids as $id) {
            $this->strategy->waitWorker($id);
        }
    }
}
