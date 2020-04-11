<?php

namespace App\Validator\Gnome;

use Symfony\Component\Validator\Constraint;

/**
 * strength validator
 * 
 * @Annotation
 */
final class IsValidStrength extends Constraint
{
    /*
     * @var string
     */
    public $message = 'Only rock gnome can have min 0 and max 150 strength, other gnomes can have a min of 0 and max of 100.';
}
