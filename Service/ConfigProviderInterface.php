<?php

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
     *
     * @return array
     */
    public function get(): array;
}
