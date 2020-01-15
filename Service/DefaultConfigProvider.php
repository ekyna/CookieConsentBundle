<?php

namespace Ekyna\Bundle\CookieConsentBundle\Service;

use Ekyna\Bundle\CookieConsentBundle\Model\Category;

/**
 * Class DefaultConfigProvider
 * @package Ekyna\Bundle\CookieConsentBundle\Service
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class DefaultConfigProvider implements ConfigProviderInterface
{
    /**
     * @var array
     */
    private $config;


    /**
     * Constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = array_replace($this->getDefault(), $config);
    }

    /**
     * @inheritDoc
     */
    public function get(): array
    {
        return $this->config;
    }

    /**
     * Returns the default config.
     *
     * @return array
     */
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
