<?php

declare(strict_types=1);

namespace Ekyna\Bundle\CookieConsentBundle\Entity;

/**
 * Class CookieConsent
 * @package Ekyna\Bundle\CookieConsentBundle\Entity
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class CookieConsent
{
    private ?int    $id  = null;
    private ?string $key = null;
    private ?string $ip  = null;
    /** @var array<string> */
    private array $categories = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function setKey(?string $key): self
    {
        $this->key = $key;

        return $this;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(?string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function setCategories(array $categories): self
    {
        $this->categories = $categories;

        return $this;
    }
}
