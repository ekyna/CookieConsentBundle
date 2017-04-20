<?php

declare(strict_types=1);

namespace Ekyna\Bundle\CookieConsentBundle\DependencyInjection;

use Ekyna\Bundle\CookieConsentBundle\Service\ConfigProviderInterface;
use Ekyna\Bundle\CookieConsentBundle\Service\Setting\CookiesSettingSchema;
use Ekyna\Bundle\CookieConsentBundle\Service\Setting\SettingConfigProvider;
use Ekyna\Bundle\SettingBundle\DependencyInjection\Compiler\RegisterSchemasPass;
use Ekyna\Bundle\SettingBundle\Manager\SettingManagerInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class EkynaCookieConsentExtension
 * @package Ekyna\Bundle\CookieConsentBundle\DependencyInjection
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class EkynaCookieConsentExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        $loader = new Loader\PhpFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.php');

        $container
            ->getDefinition('ekyna_cookie_consent.provider.config')
            ->replaceArgument(0, $config);

        $this->configureSetting($container);
    }

    /**
     * Configures the setting service (with EkynaSettingBundle).
     */
    private function configureSetting(ContainerBuilder $container): void
    {
        $bundles = $container->getParameter('kernel.bundles');
        if (!array_key_exists('EkynaSettingBundle', $bundles)) {
            return;
        }

        $container
            ->register('ekyna_cookie_consent.setting_schema', CookiesSettingSchema::class)
            ->setPublic(false)
            ->addTag(RegisterSchemasPass::TAG, [
                'namespace' => 'cookies',
                'position'  => 11,
            ]);

        $container
            ->getDefinition('ekyna_cookie_consent.provider.config')
            ->setClass(SettingConfigProvider::class)
            ->addMethodCall('setSettingManager', [new Reference('ekyna_setting.manager')])
            ->addMethodCall('setLocaleProvider', [new Reference('ekyna_resource.provider.locale')]);
    }
}
