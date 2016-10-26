<?php

namespace Chatpreview\Model;

use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;

use Zend\InputFilter\InputFilter;
//use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\StringLength;

class Chatbutton
{
    public $manager_id;
    public $font;
    public $background_color;
    public $text_color;
    public $button_text;
    public $border_color;
    public $button_dimension;
    public $button_location;
    
    // Add this property:
    private $inputFilter;
    
    public function exchangeArray(array $data)
    {
        $this->manager_id     = !empty($data['manager_id']) ? $data['manager_id'] : null;
        $this->font   = !empty($data['font']) ? $data['font'] : null;
        $this->background_color    = !empty($data['background_color']) ? $data['background_color'] : null;
        $this->text_color        = !empty($data['text_color']) ? $data['text_color'] : null;
        $this->button_text     = !empty($data['button_text']) ? $data['button_text'] : null;
        $this->border_color   = !empty($data['border_color']) ? $data['border_color'] : 1;
        $this->button_dimension        = !empty($data['button_dimension']) ? $data['button_dimension'] : null;
        $this->button_location       = !empty($data['button_location']) ? $data['button_location'] : null;
      
    }
    
    // Add the following method:
    public function getArrayCopy()
    {
        return [
            'manager_id'           => $this->manager_id,
            'font'              => $this->font,
            'background_color'  => $this->background_color,
            'text_color'        => $this->text_color,
            'button_text'       => $this->button_text,
            'border_color'      => $this->border_color,
            'button_dimension' => $this->button_dimension,
            'button_location'   => $this->button_location,
        ];
    }
    
}