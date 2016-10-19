<?php

namespace Auth\Form;

use Zend\Form\Form;

class ForgotpasswordForm extends Form
{
    public function __construct($name = null) {
        
        parent::__construct('forgotpassword');
        $this->add([
            'name' => 'id',
            'type' =>'hidden',
        ]);
        $this->add([
            'name' => 'email',
            'type' => 'text',
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
        ]);
    }
}