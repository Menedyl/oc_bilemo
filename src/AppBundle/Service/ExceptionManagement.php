<?php

namespace AppBundle\Service;

use AppBundle\Exception\ResourceValidationException;
use Symfony\Component\Validator\ConstraintViolationList;

class ExceptionManagement
{
    public function resourceValidationException(ConstraintViolationList $violationList)
    {
        $message = 'The JSON sent contains invalid data. ';

        foreach ($violationList as $violation) {
            $message .= sprintf("Field '%s': %s ", $violation->getPropertyPath(), $violation->getMessage());
        }

        throw new ResourceValidationException($message);
    }
}