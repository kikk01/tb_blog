<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UniquePseudo extends Constraint
{
    public string $message = 'This pseudo already exists.';
}