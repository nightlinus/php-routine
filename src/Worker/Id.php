<?php
declare(strict_types=1);

/**
 * Date: 18.08.17
 * Time: 12:10
 *
 * @package  php-routine
 * @author   nightlinus <m.a.ogarkov@gmail.com>
 */

namespace nightlinus\PhpRoutines\Worker;

interface Id
{
    public function toString(): string;
}
