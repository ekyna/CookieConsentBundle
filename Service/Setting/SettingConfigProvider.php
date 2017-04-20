<?php

declare(strict_types=1);

namespace Ekyna\Bundle\CookieConsentBundle\Service\Setting;

use Ekyna\Bundle\CookieConsentBundle\Service\DefaultConfigProvider;
use Ekyna\Bundle\SettingBundle\Manager\SettingManagerInterface;
use Ekyna\Component\Resource\Locale\LocaleProviderAwareTrait;

/**
 * Class SettingConfigProvider
 * @package Ekyna\Bundle\CookieConsentBundle\Service\Setting
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class SettingConfigProvider extends DefaultConfigProvider
{
    use LocaleProviderAwareTrait;

    private SettingManagerInterface $setting;
    private ?array                  $config = null;

    public function setSettingManager(SettingManagerInterface $setting): void
    {
        $this->setting = $setting;
    }

    public function get(): array
    {
        if ($this->config) {
            return $this->config;
        }

        $config = parent::get();

        $locale = $this->localeProvider->getCurrentLocale();

        $config['position'] = $this->setting->getParameter('cookies.position');
        $config['backdrop'] = $this->setting->getParameter('cookies.backdrop');
        foreach (['title', 'intro'] as $parameter) {
            $value = $this->setting->getParameter('cookies.' . $parameter, $locale);
            if (empty($value)) {
                continue;
            }
            $config['translations'][$parameter] = [$value, false];
        }

        return $this->config = $config;
    }
}
