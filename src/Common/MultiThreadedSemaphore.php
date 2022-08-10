<?php

/*
 * This file is part of the Neo4j PHP Client and Driver package.
 *
 * (c) Nagels <https://nagels.tech>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Laudis\Neo4j\Common;

use Generator;
use function hash;
use Laudis\Neo4j\Contracts\SemaphoreInterface;
use RuntimeException;
use function sem_get;
use function sem_release;

class MultiThreadedSemaphore implements SemaphoreInterface
{
    /** @var resource */
    private $semaphore;

    /**
     * @param resource $semaphore
     */
    private function __construct($semaphore)
    {
        $this->semaphore = $semaphore;
    }

    public static function create(string $key, int $max): self
    {
        $key = hash('sha512', $key, true);
        $key = substr($key, 0, 8);

        return new self(sem_get(hexdec($key), $max));
    }

    public function wait(): Generator
    {
        while (!sem_acquire($this->semaphore, true)) {
            yield;
        }
    }

    public function post(): void
    {
        if (!sem_release($this->semaphore)) {
            throw new RuntimeException('Cannot release semaphore');
        }
    }
}
