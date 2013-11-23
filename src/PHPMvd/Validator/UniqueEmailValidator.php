<?php

namespace PHPMvd\Validator;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Statement;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class UniqueEmailValidator
 *
 * @package PHPMvd\Validator
 */
class UniqueEmailValidator extends ConstraintValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        /** @var Statement $stmt */
        $stmt  = $constraint->connection->executeQuery('SELECT COUNT(1) FROM users WHERE email = :email', array(':email' => $value));
        $count = $stmt->fetchColumn(0);
        if (0 < $count) {
            $this->context->addViolation($constraint->message);
        }
    }
}
