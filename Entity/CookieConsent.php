<?php

namespace Ekyna\Bundle\CookieConsentBundle\Entity;

/**
 * Class CookieConsent
 * @package Ekyna\Bundle\CookieConsentBundle\Entity
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class CookieConsent
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $ip;

    /**
     * @var array
     */
    private $categories;


    /**
     * Returns the id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Returns the key.
     *
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * Sets the key.
     *
     * @param string $key
     *
     * @return CookieConsent
     */
    public function setKey(string $key): self
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Returns the ip.
     *
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * Sets the ip.
     *
     * @param string $ip
     *
     * @return CookieConsent
     */
    public function setIp(string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Returns the categories.
     *
     * @return array
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * Sets the categories.
     *
     * @param array $categories
     *
     * @return CookieConsent
     */
    public function setCategories(array $categories): self
    {
        $this->categories = $categories;

        return $this;
    }
}
