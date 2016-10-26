<?php

namespace Manager\Form;

use Zend\Form\Form;

//include captcha 

class ChatbuttonForm extends Form
{
    public function __construct($name = null) {
        
        parent::__construct('chatbutton');
        $this->add([
            'name' => 'manager_id',
            'type' =>'hidden',
        ]);
        $this->add([
            'name' => 'font',
            'type' =>'select',
        ]);
        $this->add([
            'name' => 'background_color',
            'type' =>'hidden',
        ]);
        $this->add([
            'name' => 'text_color',
            'type' =>'hidden',
        ]);
        $this->add([
            'name' => 'button_text',
            'type' =>'text',
        ]);
        $this->add([
            'name' => 'border_color',
            'type' =>'hidden',
        ]);
        $this->add([
            'name' => 'button_dimension',
            'type' =>'select',
        ]);
        $this->add([
            'name' => 'button_location',
            'type' =>'select',
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
        ]);
    }
}
