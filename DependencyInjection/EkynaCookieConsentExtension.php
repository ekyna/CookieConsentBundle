<?php

namespace Ekyna\Bundle\CookieConsentBundle\DependencyInjection;

use Ekyna\Bundle\CookieConsentBundle\Service\ConfigProviderInterface;
use Ekyna\Bundle\CookieConsentBundle\Service\Setting\CookiesSettingSchema;
use Ekyna\Bundle\CookieConsentBundle\Service\Setting\SettingConfigProvider;
use Ekyna\Bundle\SettingBundle\Manager\SettingsManagerInterface;
use Ekyna\Component\Resource\Locale\LocaleProviderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Class EkynaCookieConsentExtension
 * @package Ekyna\Bundle\CookieConsentBundle\DependencyInjection
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class EkynaCookieConsentExtension extends Extension
{
    /**
     * @inheritDoc
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');

        $container
            ->getDefinition(ConfigProviderInterface::class)
            ->replaceArgument(0, $config);

        $this->configureSetting($container);
    }

    /**
     * Configures the setting service (with EkynaSettingBundle).
     *
     * @param ContainerBuilder $container
     */
    private function configureSetting(ContainerBuilder $container): void
    {
        $bundles = $container->getParameter('kernel.bundles');
        if (!array_key_exists('EkynaSettingBundle', $bundles)) {
            return;
        }

        $container
            ->register(CookiesSettingSchema::class)
            ->setPublic(false)
            ->addTag('ekyna_setting.schema', [
                'namespace' => 'cookies',
                'position'  => 11,
            ]);

        $container
            ->getDefinition(ConfigProviderInterface::class)
            ->setClass(SettingConfigProvider::class)
            ->addMethodCall('setSettingManager', [new Reference(SettingsManagerInterface::class)])
            ->addMethodCall('setLocaleProvider', [new Reference(LocaleProviderInterface::class)]);
    }
}
