<?php
/**
 * @copyright   (c) tasko Products GmbH
 * @license     Commercial
 */

declare(strict_types=1);

namespace Chrisguitarguy\RequestId;

trait RequestIdStoreAwareTrait
{
    protected RequestIdStorage $requestIdStorage;

    public function setRequestIdStorage(RequestIdStorage $requestIdStorage): void
    {
        $this->requestIdStorage = $requestIdStorage;
    }
}