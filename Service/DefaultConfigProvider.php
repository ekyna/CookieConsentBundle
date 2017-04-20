<?php

declare(strict_types=1);

namespace Ekyna\Bundle\CookieConsentBundle\Service;

use Ekyna\Bundle\CookieConsentBundle\Model\Category;

/**
 * Class DefaultConfigProvider
 * @package Ekyna\Bundle\CookieConsentBundle\Service
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class DefaultConfigProvider implements ConfigProviderInterface
{
    private array $config;

    public function __construct(array $config = [])
    {
        $this->config = array_replace($this->getDefault(), $config);
    }

    public function get(): array
    {
        return $this->config;
    }

    private function getDefault(): array
    {
        return [
            'enabled'         => true,
            'name'            => 'Cookie_Consent',
            'read_more_route' => null,
            'categories'      => Category::getDefault(),
            'translations'    => [
                'title' => ['title', 'EkynaCookieConsent'],
                'intro' => ['intro', 'EkynaCookieConsent'],
            ],
            'persist'         => false,
        ];
    }
}
