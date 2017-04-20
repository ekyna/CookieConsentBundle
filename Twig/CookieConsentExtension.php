<?php

declare(strict_types=1);

namespace Ekyna\Bundle\CookieConsentBundle\Twig;

use Ekyna\Bundle\CookieConsentBundle\Service\Renderer;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class CookieConsentExtension
 * @package Ekyna\Bundle\CookieConsentBundle\Twig
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class CookieConsentExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'ekyna_cookie_consent_render',
                [Renderer::class, 'render'],
                ['is_safe' => ['html']]
            ),
            new TwigFunction(
                'ekyna_cookie_consent_category_allowed',
                [Renderer::class, 'isCategoryAllowed']
            )
        ];
    }
}
