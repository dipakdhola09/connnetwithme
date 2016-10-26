<?php

namespace Manager\Form;

use Zend\Form\Form;

//include captcha 

class ChatdesignForm extends Form
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
            'name' => 'open_font',
            'type' => 'select',
        ]);
        $this->add([
            'name' => 'open_background_color',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'open_text_color',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'open_border_color',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'open_desktop_dimension',
            'type' => 'select',
        ]);
        $this->add([
            'name' => 'open_mobile_dimension',
            'type' => 'select',
        ]);
        $this->add([
            'name' => 'open_tablet_dimension',
            'type' => 'select',
        ]);
        $this->add([
            'name' => 'pro_font',
            'type' => 'select',
        ]);
        $this->add([
            'name' => 'pro_background_color',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'pro_text_color',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'pro_border_color',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
        ]);
    }
}
