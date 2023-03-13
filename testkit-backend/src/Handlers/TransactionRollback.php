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

namespace Laudis\Neo4j\TestkitBackend\Handlers;

use Laudis\Neo4j\Exception\Neo4jException;
use Laudis\Neo4j\TestkitBackend\Contracts\RequestHandlerInterface;
use Laudis\Neo4j\TestkitBackend\Contracts\TestkitResponseInterface;
use Laudis\Neo4j\TestkitBackend\MainRepository;
use Laudis\Neo4j\TestkitBackend\Requests\TransactionRollbackRequest;
use Laudis\Neo4j\TestkitBackend\Responses\DriverErrorResponse;
use Laudis\Neo4j\TestkitBackend\Responses\TransactionResponse;

/**
 * @implements RequestHandlerInterface<TransactionRollbackRequest>
 */
final class TransactionRollback implements RequestHandlerInterface
{
    public function __construct(
        private MainRepository $repository
    ) {}

    /**
     * @param TransactionRollbackRequest $request
     */
    public function handle($request): TestkitResponseInterface
    {
        $tsx = $this->repository->getTransaction($request->getTxId());

        try {
            $tsx->rollback();
        } catch (Neo4jException $e) {
            return new DriverErrorResponse($request->getTxId(), '', $e->getMessage());
        }

        return new TransactionResponse($request->getTxId());
    }
}
