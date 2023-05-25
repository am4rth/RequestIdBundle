<?php
/**
 * @copyright   (c) tasko Products GmbH
 * @license     Commercial
 */

declare(strict_types=1);

namespace Chrisguitarguy\RequestId;

interface RequestIdStoreAwareInterface
{
    public function setRequestIdStorage(RequestIdStorage $requestIdStorage): void;
}