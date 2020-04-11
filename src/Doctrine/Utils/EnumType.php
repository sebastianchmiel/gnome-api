<?php

namespace App\Doctrine\Utils;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Adds enum type support in Doctrine entities
 */
abstract class EnumType extends Type
{
    /**
     * name
     *
     * @var string
     */
    protected $name;

    /**
     * values
     *
     * @var array
     */
    protected $values = [];

    /**
     * sql declaration
     *
     * @param array $fieldDeclaration
     * @param AbstractPlatform $platform
     * 
     * @return void
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        $values = array_map(function ($val) {
            return "'" . $val . "'";
        }, $this->values);

        return "ENUM(" . implode(", ", $values) . ")";
    }

    /**
     * convert to php from db
     *
     * @param mixed $value
     * @param AbstractPlatform $platform
     * 
     * @return void
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value;
    }

    /**
     * convert to database from php
     *
     * @param mixed $value
     * @param AbstractPlatform $platform
     * 
     * @return void
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!in_array($value, $this->values)) {
            throw new \InvalidArgumentException("Invalid '" . $this->name . "' value.");
        }
        return $value;
    }

    /**
     * get name
     *
     * @return void
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * require sql comment hint
     *
     * @param AbstractPlatform $platform
     * 
     * @return boolean
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}
