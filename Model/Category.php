<?php

declare(strict_types=1);

namespace Ekyna\Bundle\CookieConsentBundle\Model;

/**
 * Class Category
 * @package Ekyna\Bundle\CookieConsentBundle\Model
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
final class Category
{
    public const NECESSARY      = 'necessary';
    public const ANALYTIC       = 'analytic';
    public const MARKETING      = 'marketing';
    public const SOCIAL_NETWORK = 'social_network';


    /**
     * Returns all the categories constants.
     */
    public static function getConstants(): array
    {
        return [
            self::NECESSARY,
            self::ANALYTIC,
            self::MARKETING,
            self::SOCIAL_NETWORK,
        ];
    }

    /**
     * Returns the default available categories constants.
     */
    public static function getDefault(): array
    {
        return [
            self::ANALYTIC,
            self::MARKETING,
            self::SOCIAL_NETWORK,
        ];
    }

    /**
     * Returns all the category choices (for form).
     */
    public static function getChoices(): array
    {
        $prefix = 'category.';
        $suffix = '.title';

        return [
            $prefix . self::ANALYTIC . $suffix       => self::ANALYTIC,
            $prefix . self::MARKETING . $suffix      => self::MARKETING,
            $prefix . self::SOCIAL_NETWORK . $suffix => self::SOCIAL_NETWORK,
        ];
    }

    /**
     * Returns whether the given category is valid.
     */
    public static function isValid(string $category): bool
    {
        return in_array($category, self::getConstants(), true);
    }

    private function __construct()
    {
    }
}
