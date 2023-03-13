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

final class ResultNextRequest
{
    public function __construct(
        private Uuid $resultId
    ) {}

    public function getResultId(): Uuid
    {
        return $this->resultId;
    }
}
