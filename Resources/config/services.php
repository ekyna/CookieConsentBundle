<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Ekyna\Bundle\CookieConsentBundle\Controller\CookieController;
use Ekyna\Bundle\CookieConsentBundle\Form\Type\CookieConsentType;
use Ekyna\Bundle\CookieConsentBundle\Service\DefaultConfigProvider;
use Ekyna\Bundle\CookieConsentBundle\Service\Manager;
use Ekyna\Bundle\CookieConsentBundle\Service\Renderer;
use Ekyna\Bundle\CookieConsentBundle\Twig\CookieConsentExtension;

return static function (ContainerConfigurator $container) {
    $container
        ->services()

        ->set('ekyna_cookie_consent.provider.config', DefaultConfigProvider::class)
            ->args([
                abstract_arg('Cookie consent provider configuration')
            ])

        ->set('ekyna_cookie_consent.manager', Manager::class)
            ->args([
                service('request_stack'),
                service('form.factory'),
                service('router'),
                service('doctrine.orm.default_entity_manager'),
                service('ekyna_cookie_consent.provider.config'),
            ])

        ->set('ekyna_cookie_consent.renderer', Renderer::class)
            ->args([
                service('twig'),
                service('ekyna_cookie_consent.manager'),
            ])
            ->tag('twig.runtime')

        ->set('ekyna_cookie_consent.controller', CookieController::class)
            ->args([
                service('ekyna_cookie_consent.manager'),
            ])
            ->alias(CookieController::class, 'ekyna_cookie_consent.controller')->public()

        ->set('ekyna_cookie_consent.form_type.cookie_consent', CookieConsentType::class)
            ->args([
                service('ekyna_cookie_consent.manager'),
            ])
            ->tag('form.type')

        ->set('ekyna_cookie_consent.twig.cookie_consent', CookieConsentExtension::class)
            ->tag('twig.extension')
    ;
};
