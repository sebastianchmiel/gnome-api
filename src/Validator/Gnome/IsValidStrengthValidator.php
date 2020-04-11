<?php

namespace App\Validator\Gnome;

use App\Entity\Gnome;
use App\Model\Gnome\RaceType;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use App\Validator\Gnome\IsValidStrength;

final class IsValidStrengthValidator extends ConstraintValidator
{
    /**
     * validation
     * 
     * @param mixed $value
     * @param Constrint $constraint
     * 
     * @return void
     */
    public function validate($value, Constraint $constraint): void
    {
        /** @var IsValidStrength $constraint */
        if (null === $value || '' === $value) {
            return;
        }

        /** @var Gnome $gnome */
        $gnome = $this->context->getObject();

        if (
            $value < 0 ||
            ($gnome->getRace() === RaceType::ROCK && $value > 150) ||
            ($gnome->getRace() !== RaceType::ROCK && $value > 100)
        ) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
