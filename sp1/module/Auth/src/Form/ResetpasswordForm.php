<?php

namespace Auth\Form;

use Zend\Form\Form;

class ResetpasswordForm extends Form
{
    public function __construct($name = null) {
        
        parent::__construct('reset');
        $this->add([
            'name' => 'password',
            'type' => 'password',
        ]);
        $this->add([
            'name' => 'email',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'confirm_password',
            'type' => 'password',
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
        ]);
    }
}