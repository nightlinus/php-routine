<?php
declare(strict_types=1);

/**
 * Date: 17.08.17
 * Time: 23:36
 *
 * @package  php-routine
 * @author   nightlinus <m.a.ogarkov@gmail.com>
 */

namespace nightlinus\PhpRoutines\Strategy;

use nightlinus\PhpRoutines\Routine;
use nightlinus\PhpRoutines\Worker\Id;
use nightlinus\PhpRoutines\Worker\Pid;
use nightlinus\PhpRoutines\Worker\Status;

final class Fork implements Strategy
{

    public function createWorker(Routine $routine): Id
    {
        $pid = pcntl_fork();

        if ($pid === -1) {
            /** @var int $error */
            $error = pcntl_errno();
            $msg = pcntl_strerror($error);
            throw new ForkFailed("pcntl_fork failed: $msg", $error);
        }

        //when in parent return child pid
        if ($pid) {
            return Pid::fromInt($pid);
        }

        //when in child run routine and exit
        try {
            $routine->run();
            exit(0);
        } catch (\Throwable $e) {
            exit($e->getMessage());
        }
    }

    public function waitWorker(Id $id): Status
    {
        $status = 0;
        $pid = (int) $id->toString();
        pcntl_waitpid($pid, $status);

        //normal exit
        if (pcntl_wifexited($status)) {
            return Status::success();
        }

        return Status::error(pcntl_wexitstatus($status));
    }
}
