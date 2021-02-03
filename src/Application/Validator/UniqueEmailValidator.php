<?php

namespace App\Application\Validator;

use Symfony\Component\Validator\Constraint;
use App\Application\Repository\UserRepository;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueEmailValidator extends ConstraintValidator
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @inheritDoc
     */
    public function validate($value, Constraint $constraint)
    {
        if ($this->userRepository->count(["email" => $value]) > 0) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}