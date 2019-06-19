<?php

namespace Ekyna\Bundle\CookieConsentBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Ekyna\Bundle\CookieConsentBundle\Entity\CookieConsent;
use Ekyna\Bundle\CookieConsentBundle\Form\Type\CookieConsentType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class Manager
 * @package Ekyna\Bundle\CookieConsentBundle\Service
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class Manager
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ConfigProviderInterface
     */
    private $configProvider;

    /**
     * @var array
     */
    private $config;

    /**
     * @var array The cookie data
     */
    private $data;


    /**
     * Constructor.
     *
     * @param RequestStack            $requestStack
     * @param FormFactoryInterface    $formFactory
     * @param UrlGeneratorInterface   $urlGenerator
     * @param EntityManagerInterface  $entityManager
     * @param ConfigProviderInterface $configProvider
     */
    public function __construct(
        RequestStack $requestStack,
        FormFactoryInterface $formFactory,
        UrlGeneratorInterface $urlGenerator,
        EntityManagerInterface $entityManager,
        ConfigProviderInterface $configProvider
    ) {
        $this->requestStack = $requestStack;
        $this->formFactory = $formFactory;
        $this->urlGenerator = $urlGenerator;
        $this->entityManager = $entityManager;
        $this->configProvider = $configProvider;
    }

    /**
     * Returns the configuration.
     *
     * @return array
     */
    public function getConfig(): array
    {
        if ($this->config) {
            return $this->config;
        }

        return $this->config = $this->configProvider->get();
    }

    /**
     * Returns the cookie consent form.
     *
     * @return FormInterface
     */
    public function getForm(): FormInterface
    {
        $data = $this->getCookieData()['categories'];

        return $this->formFactory->create(CookieConsentType::class, $data, [
            'action' => $this->urlGenerator->generate('ekyna_cookie_consent_submit'),
        ]);
    }

    /**
     * Handles the cookie consent form.
     */
    public function handleForm()
    {
        // TODO
    }

    /**
     * Saves the user cookie consent.
     *
     * @param Response $response
     * @param string[] $categories The category names allowed by the user
     * @param string   $ip         The user key
     *
     * @throws \Exception
     */
    public function saveCookieConsent(Response $response, array $categories, string $ip = null): void
    {
        $data = $this->getCookieData();

        $reload = !empty(array_diff_assoc($data['categories'], $categories));

        $data['categories'] = $categories;

        $this->setCookieData($data);

        $cookie = new Cookie($this->getConfig()['name'], json_encode($data), new \DateTime('+1 year'), '/', null, null, true, true);
        $response->headers->setCookie($cookie);

        $response->setContent(json_encode(['reload' => $reload]));
        $response->headers->set('Content-Type', 'application/json');

        if (!$this->getConfig()['persist'] || empty($ip)) {
            return;
        }

        $consent = $this->entityManager->getRepository(CookieConsent::class)->findOneBy(['key' => $data['key']]);
        if (!$consent) {
            $consent = new CookieConsent();
            $consent->setKey($data['key']);
        }

        $consent
            ->setIp($ip)
            ->setCategories($categories);

        $this->entityManager->persist($consent);
        $this->entityManager->flush();
    }

    /**
     * Check if cookie consent has already been saved.
     *
     * @return bool
     */
    public function isContentSaved(): bool
    {
        return $this->getRequest()->cookies->has($this->getConfig()['name']);
    }

    /**
     * Check if given cookie category is permitted by user.
     *
     * @param string $category
     *
     * @return bool
     */
    public function isCategoryAllowed(string $category): bool
    {
        $categories = $this->getCookieData()['categories'];

        return isset($categories[$category]) && 1 === $categories[$category];
    }

    /**
     * Sets the cookie data.
     *
     * @param array $data
     */
    protected function setCookieData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * Returns the cookie data.
     *
     * @return array
     */
    protected function getCookieData(): array
    {
        if ($this->data) {
            return $this->data;
        }

        if ($this->isContentSaved()) {
            $data = @json_decode($this->getRequest()->cookies->get($this->getConfig()['name'], '{}'), true);

            if (!empty($data)) {
                return $this->data = $data;
            }
        }

        return $this->data = $this->getDefaultData();
    }

    /**
     * Returns the category names.
     *
     * @return array
     */
    public function getCategories(): array
    {
        return $this->getConfig()['categories'];
    }

    /**
     * Returns the default data.
     *
     * @return array
     */
    private function getDefaultData(): array
    {
        $data = [
            'key'        => uniqid(),
            'categories' => [],
        ];

        foreach ($this->getCategories() as $category) {
            $data['categories'][$category] = 0;
        }

        return $data;
    }

    /**
     * Returns the current request.
     *
     * @return Request
     */
    private function getRequest(): Request
    {
        return $this->requestStack->getCurrentRequest();
    }
}
