<?php

declare(strict_types=1);

/*
 * This file is part of the Neo4j PHP Client and Driver package.
 *
 * (c) Nagels <https://nagels.tech>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Laudis\Neo4j\TestkitBackend\Responses;

use Laudis\Neo4j\TestkitBackend\Contracts\TestkitResponseInterface;
use Symfony\Component\Uid\Uuid;

/**
 * Represents a transaction instance on the backend.
 */
final class TransactionResponse implements TestkitResponseInterface
{
    public function __construct(
        private Uuid $id
    ) {}

    public function jsonSerialize(): array
    {
        return [
            'name' => 'Transaction',
            'data' => [
                'id' => $this->id->toRfc4122(),
            ],
        ];
    }
}
