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

use Laudis\Neo4j\Authentication\Authenticate;
use Laudis\Neo4j\Databags\DriverConfiguration;
use Laudis\Neo4j\DriverFactory;
use Laudis\Neo4j\Formatter\SummarizedResultFormatter;
use Laudis\Neo4j\TestkitBackend\Contracts\RequestHandlerInterface;
use Laudis\Neo4j\TestkitBackend\MainRepository;
use Laudis\Neo4j\TestkitBackend\Requests\NewDriverRequest;
use Laudis\Neo4j\TestkitBackend\Responses\DriverResponse;
use Symfony\Component\Uid\Uuid;

/**
 * @implements RequestHandlerInterface<NewDriverRequest>
 */
final class NewDriver implements RequestHandlerInterface
{
    public function __construct(
        private MainRepository $repository
    ) {}

    /**
     * @param NewDriverRequest $request
     */
    public function handle($request): DriverResponse
    {
        $user = $request->getAuthToken()->getPrincipal();
        $pass = $request->getAuthToken()->getCredentials();

        $ua = $request->getUserAgent();
        $config = DriverConfiguration::default();

        if ($ua) {
            $config = $config->withUserAgent($ua);
        }

        $formatter = SummarizedResultFormatter::create();
        $authenticate = Authenticate::basic($user, $pass);
        $driver = DriverFactory::create($request->getUri(), $config, $authenticate, $formatter);

        $id = Uuid::v4();
        $this->repository->addDriver($id, $driver);

        return new DriverResponse($id);
    }
}
