<?php

namespace Auth\Form;

use Zend\Form\Form;

//include captcha 
use Zend\Form\Element\Captcha;
use Zend\Captcha\Image as CaptchaImage;

class SignupForm extends Form
{
    public function __construct($name = null) {
        
        parent::__construct('signup');
        $this->add([
            'name' => 'user_id',
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
            'name' => 'company',
            'type' => 'text',
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
            'name' => 'confirm_password',
            'type' => 'password',
        ]);
        $this->add([
            'name' => 'phone',
            'type' => 'text',                                                  
        ]);
        $this->add([
            'name' => 'ext',
            'type' => 'text',                                                  
        ]);
        $this->add([
            'name' => 'no_of_employee',
            'type' => 'select',
        ]);
        $this->add([
           'name' => 'no_of_employees',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'plan',
            'type' => 'select',
        ]);
        $this->add([
            'name' => 'plans',
            'type' => 'hidden',
        ]);
 
        //Add captcha field
        $this->add(array(
			'type' => 'Zend\Form\Element\Captcha',
			'name' => 'captcha',
			'options' => array(
				'label' => 'captcha',
				'captcha' => new \Zend\Captcha\Figlet(),
			),
		));
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
        ]);
        
        
    }
}
