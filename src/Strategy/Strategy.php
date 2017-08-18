<?php
declare(strict_types=1);

/**
 * Date: 17.08.17
 * Time: 23:40
 *
 * @package  php-routine
 * @author   nightlinus <m.a.ogarkov@gmail.com>
 */

namespace nightlinus\PhpRoutines\Strategy;

use nightlinus\PhpRoutines\Routine;
use nightlinus\PhpRoutines\Worker\Id;
use nightlinus\PhpRoutines\Worker\Status;

interface Strategy
{
    public function createWorker(Routine $routine): Id;

    public function waitWorker(Id $id): Status;
}
