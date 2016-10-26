<?php

namespace Manager\Model;

use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;

use Zend\InputFilter\InputFilter;
//use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\StringLength;

class Chatdesign
{
    public $manager_id;
    public $font;
    public $background_color;
    public $text_color;
    public $button_text;
    public $border_color;
    public $button_dimension;
    public $button_location;
    public $open_font;
    public $open_background_color;
    public $open_text_color;
    public $open_border_color;
    public $open_desktop_dimension;
    public $open_mobile_dimension;
    public $open_tablet_dimension;
    public $pro_font;
    public $pro_background_color;
    public $pro_text_color;
    public $pro_border_color;
    
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
        $this->open_font   = !empty($data['open_font']) ? $data['open_font'] : null;
        $this->open_background_color    = !empty($data['open_background_color']) ? $data['open_background_color'] : null;
        $this->open_text_color        = !empty($data['open_text_color']) ? $data['open_text_color'] : null;
        $this->open_border_color   = !empty($data['open_border_color']) ? $data['open_border_color'] : 1;
        $this->open_desktop_dimension        = !empty($data['open_desktop_dimension']) ? $data['open_desktop_dimension'] : null;
        $this->open_mobile_dimension       = !empty($data['open_mobile_dimension']) ? $data['open_mobile_dimension'] : null;
        $this->open_tablet_dimension       = !empty($data['open_tablet_dimension']) ? $data['open_tablet_dimension'] : null;
        $this->pro_font = !empty($data['pro_font']) ? $data['pro_font'] : null;
        $this->pro_background_color = !empty($data['pro_background_color']) ? $data['pro_background_color'] : null;
        $this->pro_text_color = !empty($data['pro_text_color']) ? $data['pro_text_color'] : null;
        $this->pro_border_color = !empty($data['pro_border_color']) ? $data['pro_border_color'] : null;
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
            'open_font'                 => $this->open_font,
            'open_background_color'     => $this->open_background_color,
            'open_text_color'           => $this->open_text_color,
            'open_border_color'         => $this->open_border_color,
            'open_desktop_dimension'    => $this->open_desktop_dimension,
            'open_mobile_dimension'     => $this->open_mobile_dimension,
            'open_tablet_dimension'     => $this->open_tablet_dimension,
            'pro_font'                  => $this->pro_font,
            'pro_background_color'      => $this->pro_background_color,
            'pro_text_color'            => $this->pro_text_color,
            'pro_border_color'          => $this->pro_border_color,
        ];
    }
    
    /* 
     * Add the following methods: 
     * Set Input Filter
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new DomainException(sprintf(
            '%s does not allow injection of an alternate input filter',
            __CLASS__
        ));
    }
    
    /*
     * Get Input Filter
     */
    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name' => 'manager_id',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);
        $inputFilter->add([
            'name' => 'background_color',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'text_color',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'button_text',
            'required' => True,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'border_color',
            'required' => True,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                    ],
                ],
            ],
        ]);
        $inputFilter->add([
            'name' => 'open_background_color',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'open_text_color',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'open_border_color',
            'required' => True,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                    ],
                ],
            ],
        ]);
        $inputFilter->add([
            'name' => 'pro_background_color',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'pro_text_color',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'pro_border_color',
            'required' => True,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                    ],
                ],
            ],
        ]);
        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}