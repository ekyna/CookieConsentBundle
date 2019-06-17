<?php

namespace Ekyna\Bundle\CookieConsentBundle\Service;

use Twig\Environment;

/**
 * Class Renderer
 * @package Ekyna\Bundle\CookieConsentBundle\Service
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class Renderer
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var Manager
     */
    private $manager;


    /**
     * Constructor.
     *
     * @param Environment $twig
     * @param Manager     $manager
     */
    public function __construct(Environment $twig, Manager $manager)
    {
        $this->twig = $twig;
        $this->manager = $manager;
    }

    /**
     * Renders the cookie consent widget.
     *
     * @param array $options
     *
     * @return string
     */
    public function render(array $options = []): string
    {
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

        $config = $this->manager->getConfig();

        $form = $this->manager->getForm();

        return $this->twig->render('@EkynaCookieConsent/cookie_consent.html.twig', [
            'position'        => $config['position'],
            'read_more_route' => $config['read_more_route'],
            'translations'    => $config['translations'],
            'options'         => $options,
            'form'            => $form->createView(),
        ]);
    }
}
