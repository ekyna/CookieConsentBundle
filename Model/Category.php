<?php

namespace Ekyna\Bundle\CookieConsentBundle\Model;

/**
 * Class Category
 * @package Ekyna\Bundle\CookieConsentBundle\Model
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
final class Category
{
    const NECESSARY      = 'necessary';
    const ANALYTIC       = 'analytic';
    const MARKETING      = 'marketing';
    const SOCIAL_NETWORK = 'social_network';


    /**
     * Returns all the categories constants.
     *
     * @return array
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
     *
     * @return array
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
     *
     * @return array
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
     *
     * @param string $category
     *
     * @return bool
     */
    public static function isValid(string $category): bool
    {
        return in_array($category, self::getConstants(), true);
    }
}
