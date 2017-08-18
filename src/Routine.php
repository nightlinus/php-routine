<?php
declare(strict_types=1);

/**
 * Date: 17.08.17
 * Time: 17:40
 *
 * @package  php-routine
 * @author   nightlinus <m.a.ogarkov@gmail.com>
 */

namespace nightlinus\PhpRoutines;

final class Routine
{
    /**
     * @var callable
     */
    private $callable;

    /**
     * @var string
     */
    private $name = '';

    /**
     * @var array
     */
    private $arguments = [];

    private function __construct()
    {
    }

    public static function fromCallable(callable $callable): self
    {
        $instance = new static();
        $instance->callable = $callable;

        return $instance;
    }

    public function named(string $name): self
    {
        $instance = clone $this;
        $instance->name = $name;

        return $instance;
    }

    public function withArguments(...$arguments): self
    {
        $instance = clone $this;
        $instance->arguments = $arguments;

        return $instance;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function run(): void
    {
        ($this->callable)(...$this->arguments);
    }
}
