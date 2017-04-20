<?php

declare(strict_types=1);

namespace Ekyna\Bundle\CookieConsentBundle\Model;

/**
 * Class Position
 * @package Ekyna\Bundle\CookieConsentBundle\Model
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
final class Position
{
    public const CENTERED     = 'centered';
    public const BOTTOM_RIGHT = 'bottom-right';


    /**
     * Returns the position choices (for form).
     */
    public static function getChoices(): array
    {
        return [
            'position.' . self::CENTERED     => self::CENTERED,
            'position.' . self::BOTTOM_RIGHT => self::BOTTOM_RIGHT,
        ];
    }

    /**
     * Returns all the position constants.
     */
    public static function getConstants(): array
    {
        return [
            self::CENTERED,
            self::BOTTOM_RIGHT,
        ];
    }

    /**
     * Returns whether the given position is valid.
     */
    public static function isValid(string $position): bool
    {
        return in_array($position, self::getConstants(), true);
    }

    private function __construct()
    {
    }
}
