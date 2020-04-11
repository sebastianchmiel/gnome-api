<?php

namespace App\Doctrine\Utils;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

/**
 * Adds tinyint column support in Doctrine entities
 */
final class TinyintType extends Type
{
    /**
     * name
     *
     * @return string
     */
    public function getName()
    {
        return 'tinyint';
    }

    /**
     * Gets the SQL declaration snippet for a field of this type.
     * 
     * @param array $fieldDeclaration
     * @param AbstractPlatform $platform
     * 
     * @return void
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'TINYINT' . (empty($fieldDeclaration['length']) ? '' : " ({$fieldDeclaration['length']})") . (empty($fieldDeclaration['unsigned']) ? '' : ' UNSIGNED');
    }

    /**
     * convert to php value from db
     * 
     * @param mixed $value
     * @param AbstractPlatform $platform
     * 
     * @return void
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return ($value === null) ? null : intval($value);
    }

    /**
     * convert to database value
     *
     * @param mixed $value
     * @param AbstractPlatform $platform
     * 
     * @return void
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return ($value === null) ? null : intval($value);
    }

    /**
     * require sql comment hint
     *
     * @param AbstractPlatform $platform
     * 
     * @return boolean
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
