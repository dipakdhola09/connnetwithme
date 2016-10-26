<?php

namespace Manager\Model;

use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;

use Zend\InputFilter\InputFilter;
//use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\EmailAddress;
use Zend\Validator\StringLength;
use Zend\Validator\Identical;
use Zend\Validator\Digits;
use Zend\I18n\Validator\Alpha;
use Zend\I18n\Validator\Alnum;
use Zend\Validator\File\Size;


class Manager
{
    public $agent_id;
    public $manager_id;
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $department;
    public $photo;
    public $status;
    public $created_at;
    public $updated_at;
    
    // Add this property:
    private $inputFilter;

    public function exchangeArray(array $data,$password,$manager)
    {
        $this->agent_id     = !empty($data['agent_id']) ? $data['agent_id'] : null;
        $this->manager_id   = !empty($manager['manager_id']) ? $manager['manager_id'] : null;
        $this->first_name   = !empty($data['first_name']) ? $data['first_name'] : null;
        $this->last_name    = !empty($data['last_name']) ? $data['last_name'] : null;
        $this->email        = !empty($data['email']) ? $data['email'] : null;
        $this->password     = !empty($password['password']) ? $password['password'] : null;
        $this->department   = !empty($data['department']) ? $data['department'] : null;
        $this->photo        = !empty($data['photo']) ? $data['photo'] : null;
        $this->status       = !empty($data['status']) ? $data['status'] : null;
        $this->created_at   = !empty($data['created_at']) ? $data['created_at'] : date('Y-m-d');
        $this->updated_at   = !empty($data['updated_at']) ? $data['updated_at'] : date('Y-m-d');
      
    }
    
    // Add the following method:
    public function getArrayCopy()
    {
        return [
            'agent_id'      => $this->agent_id,
            'manager_id'    => $this->manager_id,
            'first_name'    => $this->first_name,
            'last_name'     => $this->last_name,
            'email'         => $this->email,
            'password'      => $this->password,
            'department'    => $this->department,
            'photo'         => $this->photo,
            'status'        => $this->status,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at
           
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
            'name' => 'agent_id',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'first_name',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'name' => Alpha::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 2,
                        'max' => 20,
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'last_name',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'name' => Alpha::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 2,
                        'max' => 20,
                    ],
                ],
            ],
        ]);
        
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
                        'max' => 30,
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'photo',
            'required' => True,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => Size::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'max' => '2MB',
                    ],
                ],
            ],
        ]);
        
        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
   
}
