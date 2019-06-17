<?php

namespace Ekyna\Bundle\CookieConsentBundle\Twig;

use Ekyna\Bundle\CookieConsentBundle\Service\Manager;
use Ekyna\Bundle\CookieConsentBundle\Service\Renderer;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class Extension
 * @package Ekyna\Bundle\CookieConsentBundle\Twig
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class Extension extends AbstractExtension
{
    /**
     * @var Manager
     */
    private $manager;

    /**
     * @var Renderer
     */
    private $renderer;


    /**
     * Constructor.
     *
     * @param Manager  $manager
     * @param Renderer $renderer
     */
    public function __construct(Manager $manager, Renderer $renderer)
    {
        $this->manager = $manager;
        $this->renderer = $renderer;
    }

    /**
     * @inheritDoc
     */
    public function getFunctions()
    {
        return [
            new TwigFunction(
                'ekyna_cookie_consent_render',
                [$this->renderer, 'render'],
                ['is_safe' => ['html']]
            ),
            new TwigFunction(
                'ekyna_cookie_consent_category_allowed',
                [$this->manager, 'isCategoryAllowed']
            )
        ];
    }
}
