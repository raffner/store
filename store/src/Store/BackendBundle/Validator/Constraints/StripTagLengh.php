<?php

namespace Store\BackendBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;



/**
 * Classe qui représente ma contrainte
 * class StripTagLengh
 * @Annotation
 */


class StripTagLengh extends Constraint{

    public $message = 'Le texte est trop long';
}



