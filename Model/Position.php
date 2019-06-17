<?php

namespace Ekyna\Bundle\CookieConsentBundle\Model;

/**
 * Class Position
 * @package Ekyna\Bundle\CookieConsentBundle\Model
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
final class Position
{
    const CENTERED     = 'centered';
    const BOTTOM_RIGHT = 'bottom-right';


    /**
     * Returns the position choices (for form).
     *
     * @return array
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
     *
     * @return array
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
     *
     * @param string $position
     *
     * @return bool
     */
    public static function isValid(string $position): bool
    {
        return in_array($position, self::getConstants(), true);
    }
}
