<?php

namespace Auth\Model;

use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\EmailAddress;
use Zend\Validator\StringLength;
use Zend\Validator\Identical;

class Forgot
{
    public $email;
    
    // Add this property:
    private $inputFilter;

    public function exchangeArray(array $data)
    {
        $this->email = !empty($data['email']) ? $data['email'] : null;
    }
    
    // Add the following method:
    public function getArrayCopy()
    {
        return [
            'email' => $this->email,
        ];
    }
    
    /* 
     * Add the following methods: 
     * set Inputfilter
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new DomainException(sprintf(
            '%s does not allow injection of an alternate input filter',
            __CLASS__
        ));
    }
    
    /*
     * Get Input Filter for form element
     */
    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name' => 'email',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => EmailAddress::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 5,
                        'max' => 20,
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'password',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => Alnum::class,
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 5,
                        'max' => 20,
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'confirm_password',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'name' => Alnum::class,
                    'name' => Identical::class,
                    'options' => [
                        'token' => 'password',
                        'encoding' => 'UTF-8',
                        'min' => 5,
                        'max' => 20,
                    ],
                ],
            ],
        ]);
        
        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}
