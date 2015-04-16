<?php

namespace Store\BackendBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class StripTagLenghValidator extends ConstraintValidator{

    public function validate($value, Constraint $constraint){
        //si la valeur de maz chaine de caractère avec suppression des tags html est supérieure à 500 caractères
        if(500 < strlen(strip_tags($value))){
                $this->context->addViolation(
                    $constraint->message, array('%string%' =>value));

    }
}
}

