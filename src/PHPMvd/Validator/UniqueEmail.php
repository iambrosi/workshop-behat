<?php

namespace PHPMvd\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Class UniqueEmail
 *
 * @package PHPMvd\Validator
 */
class UniqueEmail extends Constraint
{
    public $message = 'El email ya existe.';

    public $connection = null;

    /**
     * {@inheritdoc}
     */
    public function getDefaultOption()
    {
        return 'connection';
    }
}
