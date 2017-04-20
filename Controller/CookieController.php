<?php

declare(strict_types=1);

namespace Ekyna\Bundle\CookieConsentBundle\Controller;

use Ekyna\Bundle\CookieConsentBundle\Service\Manager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CookieController
 * @package Ekyna\Bundle\CookieConsentBundle\Controller
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class CookieController
{
    private Manager $manager;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function submit(Request $request): Response
    {
        $form = $this->manager->getForm();

        $form->handleRequest($request);

        $response = new Response();

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->saveCookieConsent($response, $form->getData());
        }

        return $response;
    }
}
