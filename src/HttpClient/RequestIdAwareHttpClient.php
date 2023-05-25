<?php declare(strict_types=1);

/*
 * This file is part of chrisguitarguy/request-id-bundle

 * Copyright (c) Christopher Davis <http://christopherdavis.me>
 *
 * For full copyright information see the LICENSE file distributed
 * with this source code.
 *
 * @license     http://opensource.org/licenses/MIT MIT
 */

namespace Chrisguitarguy\RequestId\HttpClient;

use Chrisguitarguy\RequestId\RequestIdStorage;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Contracts\HttpClient\ResponseStreamInterface;

class RequestIdAwareHttpClient implements HttpClientInterface
{
    /**
     * @var RequestIdStorage
     */
    private $requestIdStorage;

    /**
     * @var HttpClientInterface
     */
    private $client;

    /**
     * @var string
     */
    private $requestHeader;

    public function __construct(HttpClientInterface $client, string $requestHeader, RequestIdStorage $requestIdStorage){
        $this->client = $client;
        $this->requestHeader = $requestHeader;
        $this->requestIdStorage = $requestIdStorage;
    }

    public function request(string $method, string $url, array $options = []): ResponseInterface
    {
        return $this->client->request($method, $url, $this->prepareOptions($options));
    }

    public function withOptions(array $options): static
    {
        $clone = clone $this;
        $clone->client = $this->client->withOptions($this->prepareOptions($options));

        return $clone;
    }

    public function stream($responses, float $timeout = null): ResponseStreamInterface
    {
        return $this->client->stream($responses, $timeout);
    }

    private function prepareOptions(array $options): array
    {
        $options['headers'] = $options['headers'] ?? [];
        $options['headers'][$this->requestHeader] = $this->requestIdStorage->getRequestId();

        return $options;
    }
}