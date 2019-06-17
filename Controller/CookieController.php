<?php

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
    /**
     * @var Manager
     */
    private $manager;


    /**
     * Constructor.
     *
     * @param Manager $manager
     */
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Cookie consent form submission.
     *
     * @param Request $request
     *
     * @return Response
     * @throws \Exception
     */
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
