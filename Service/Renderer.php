<?php

declare(strict_types=1);

namespace Ekyna\Bundle\CookieConsentBundle\Service;

use Twig\Environment;

/**
 * Class Renderer
 * @package Ekyna\Bundle\CookieConsentBundle\Service
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class Renderer
{
    private Environment $twig;
    private Manager $manager;

    public function __construct(Environment $twig, Manager $manager)
    {
        $this->twig = $twig;
        $this->manager = $manager;
    }

    public function isCategoryAllowed(string $category): bool
    {
        return $this->manager->isCategoryAllowed($category);
    }

    /**
     * Renders the cookie consent widget.
     */
    public function render(array $options = []): string
    {
        $config = $this->manager->getConfig();

        if (!$config['enabled']) {
            return '';
        }

        $options = array_replace([
            'render_if_saved' => false, // Whether to render even if consent has been saved.
            'expanded'        => false, // Whether to show settings
            'dialog'          => true,  // Whether to render as a dialog/popup
        ], $options);

        if (!$options['render_if_saved'] && $this->manager->isContentSaved()) {
            return '';
        }

        if (!$options['dialog']) {
            $options['expanded'] = true;
        }

        $form = $this->manager->getForm();

        return $this->twig->render('@EkynaCookieConsent/cookie_consent.html.twig', [
            'position'        => $config['position'],
            'backdrop'        => $config['backdrop'],
            'read_more_route' => $config['read_more_route'],
            'translations'    => $config['translations'],
            'options'         => $options,
            'form'            => $form->createView(),
        ]);
    }
}
