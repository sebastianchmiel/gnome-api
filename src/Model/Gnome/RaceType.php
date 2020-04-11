<?php

namespace App\Model\Gnome;

use App\Doctrine\Utils\EnumType;

/**
 * race types
 */
final class RaceType extends EnumType
{
    const ROCK = 'rock';
    const FOREST = 'forest';
    const RIVER = 'river';
    const FIRE = 'fire';
    const SKY = 'sky';

    /**
     * @var string
     */
    protected $name = self::class;

    /**
     * values
     *
     * @var array
     */
    protected $values = [
        self::ROCK => self::ROCK,
        self::FOREST => self::FOREST,
        self::RIVER => self::RIVER,
        self::FIRE => self::FIRE,
        self::SKY => self::SKY,
    ];
}
