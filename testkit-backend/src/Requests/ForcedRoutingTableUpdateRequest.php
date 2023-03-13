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

namespace Laudis\Neo4j\TestkitBackend\Requests;

use Symfony\Component\Uid\Uuid;

final class ForcedRoutingTableUpdateRequest
{
    /**
     * @param iterable<string> $bookmarks
     */
    public function __construct(
        private Uuid $driverId,
        private ?string $database,
        private ?iterable $bookmarks
    ) {}

    public function getDriverId(): Uuid
    {
        return $this->driverId;
    }

    public function getDatabase(): ?string
    {
        return $this->database;
    }

    /**
     * @return iterable<string>
     */
    public function getBookmarks(): ?iterable
    {
        return $this->bookmarks;
    }
}
