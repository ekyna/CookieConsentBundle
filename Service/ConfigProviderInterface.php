<?php

declare(strict_types=1);

namespace Ekyna\Bundle\CookieConsentBundle\Service;

/**
 * Class ConfigProviderInterface
 * @package Ekyna\Bundle\CookieConsentBundle\Service
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
interface ConfigProviderInterface
{
    /**
     * Returns the configuration.
     */
    public function get(): array;
}
