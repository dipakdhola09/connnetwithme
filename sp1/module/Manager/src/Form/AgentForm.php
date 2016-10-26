<?php

namespace Manager\Form;

use Zend\Form\Form;

//include captcha 

class AgentForm extends Form
{
    public function __construct($name = null) {
        
        parent::__construct('manager');
        $this->add([
            'name' => 'agent_id',
            'type' =>'hidden',
        ]);
        $this->add([
            'name' => 'first_name',
            'type' => 'text',
        ]);
        $this->add([
            'name' => 'last_name',
            'type' => 'text',
        ]);
        $this->add([
            'name' => 'email',
            'type' => 'text',
        ]);
        $this->add([
            'name' => 'department',
            'type' => 'select',
        ]);

        $this->add([
           'name' => 'photo',
            'type' => 'file',
        ]);
 
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
        ]);
        
        
    }
}
