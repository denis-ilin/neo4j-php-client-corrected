<?php

declare(strict_types=1);

/*
 * This file is part of the Laudis Neo4j package.
 *
 * (c) Laudis technologies <http://laudis.tech>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Laudis\Neo4j\TestkitBackend\Requests;

use Symfony\Component\Uid\Uuid;

final class SessionReadTransactionRequest
{
    /** @var iterable<string, array|scalar|null> */
    private iterable $txMeta;

    /**
     * @param iterable<string, array|scalar|null>|null $txMeta
     */
    public function __construct(
        private Uuid $sessionId,
        ?iterable $txMeta = null,
        private ?int $timeout = null
    ) {
        $this->txMeta = $txMeta ?? [];
    }

    public function getSessionId(): Uuid
    {
        return $this->sessionId;
    }

    /**
     * @return iterable<string, array|scalar|null>
     */
    public function getTxMeta(): iterable
    {
        return $this->txMeta;
    }

    public function getTimeout(): ?int
    {
        return $this->timeout;
    }
}
