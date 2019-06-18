<?php

namespace Ekyna\Bundle\CookieConsentBundle\Service\Setting;

use Ekyna\Bundle\CookieConsentBundle\Service\DefaultConfigProvider;
use Ekyna\Bundle\SettingBundle\Manager\SettingsManagerInterface;
use Ekyna\Component\Resource\Locale\LocaleProviderAwareTrait;

/**
 * Class SettingConfigProvider
 * @package Ekyna\Bundle\CookieConsentBundle\Service\Setting
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class SettingConfigProvider extends DefaultConfigProvider
{
    use LocaleProviderAwareTrait;

    /**
     * @var SettingsManagerInterface
     */
    private $setting;

    /**
     * @var array
     */
    private $config;


    /**
     * Sets the setting manager.
     *
     * @param SettingsManagerInterface $setting
     */
    public function setSettingManager(SettingsManagerInterface $setting)
    {
        $this->setting = $setting;
    }

    /**
     * @inheritDoc
     */
    public function get(): array
    {
        if ($this->config) {
            return $this->config;
        }

        $config = parent::get();
        $locale = $this->localeProvider->getCurrentLocale();

        $config['position'] = $this->setting->getParameter('cookies.position');
//        $config['categories'] = $this->setting->getParameter('cookies.categories');
        foreach (['title', 'intro'] as $parameter) {
            $value = $title = $this->setting->getParameter('cookies.' . $parameter, $locale);
            if (empty($value)) {
                continue;
            }
            $config['translations'][$parameter] = [$value, false];
        }

        return $this->config = $config;
    }
}
