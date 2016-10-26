<?php

namespace Auth\Form;

use Zend\Form\Form;

class LoginForm extends Form
{
    public function __construct($name = null) {
        
        parent::__construct('login');
        $this->add([
            'name' => 'id',
            'type' =>'hidden',
        ]);
        $this->add([
            'name' => 'email',
            'type' => 'text',
        ]);
        $this->add([
            'name' => 'password',
            'type' => 'password',
        ]);
        $this->add([
            'name' => 'user_type',
            'type' => 'Zend\Form\Element\Radio',
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
        ]);
    }
}