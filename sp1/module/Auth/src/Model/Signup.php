<?php

namespace Auth\Model;

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
use Zend\Validator\Db\RecordExists;
use Zend\Db\Adapter\Adapter;


class Signup
{
    public $user_id;
    public $first_name;
    public $last_name;
    public $company;
    public $email;
    public $password;
    public $phone;
    public $ext;
    public $no_of_employee;
    public $plan;
    public $user_type;
    public $status;
    public $confirm_email;
    public $created_at;
    public $updated_at;
    

    // Add this property:
    private $inputFilter;
    

    public function exchangeArray(array $data)
    {
        $this->user_id     = !empty($data['user_id']) ? $data['user_id'] : null;
        $this->first_name = !empty($data['first_name']) ? $data['first_name'] : null;
        $this->last_name = !empty($data['last_name']) ? $data['last_name'] : null;
        $this->company = !empty($data['company']) ? $data['company'] : null;
        $this->email = !empty($data['email']) ? $data['email'] : null;
        $this->password  = !empty($data['password']) ? $data['password'] : null;
        $this->phone  = !empty($data['phone']) ? $data['phone'] : null;
        $this->ext  = !empty($data['ext']) ? $data['ext'] : null;
        $this->no_of_employees  = !empty($data['no_of_employees']) ? $data['no_of_employees'] : null;
        $this->plans  = !empty($data['plans']) ? $data['plans'] : null;
        $this->user_type  = !empty($data['user_type']) ? $data['user_type'] : 'Manager';
        $this->status  = !empty($data['status']) ? $data['status'] : 'Active';
        //$this->confirm_email  = !empty($data['confirm_email']) ? $data['confirm_email'] : null;
        $this->created_at  = !empty($data['created_at']) ? $data['created_at'] : date('Y-m-d');
        $this->updated_at  = !empty($data['updated_at']) ? $data['updated_at'] : date('Y-m-d');
    }
    
    // Add the following method:
    public function getArrayCopy()
    {
        return [
            'user_id'     => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'company' => $this->company,
            'email' => $this->email,
            'password'  => $this->password,
            'phone' => $this->phone,
            'ext' => $this->ext,
            'no_of_empoloyee' => $this->employees,
            'plan' =>  $this->use,
            'user_type' => $this->user_type,
            'status' => $this->status,
            'created_at' =>  $this->created_at,
            'updated_at' =>  $this->updated_at,
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
            'name' => 'user_id',
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
            'name' => 'company',
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
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
                        'max' => 20,
                        'table' => 'users',
                        'field' => 'email',
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
        
        $inputFilter->add([
            'name' => 'phone',
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'name' => Digits::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 5,
                        'max' => 15,
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'ext',
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'no_of_employees',
            'required' => TRUE,
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
            'name' => 'plans',
            'required' => TRUE,
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
