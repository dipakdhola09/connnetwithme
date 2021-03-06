<?php

namespace Agent\Model;

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


class Agent
{
    public $agent_id;
    public $first_name;
    public $last_name;
    public $email;
    public $department;
    public $photo;
    public $status;
    public $created_at;
    public $updated_at;


    public function exchangeArray(array $data)
    {
        $this->agent_id     = !empty($data['agent_id']) ? $data['agent_id'] : null;
        $this->first_name   = !empty($data['first_name']) ? $data['first_name'] : null;
        $this->last_name    = !empty($data['last_name']) ? $data['last_name'] : null;
        $this->email        = !empty($data['email']) ? $data['email'] : null;
        $this->department   = !empty($data['department']) ? $data['department'] : null;
        $this->photo        = !empty($data['photo']) ? $data['photo'] : null;
        $this->status       = !empty($data['status']) ? $data['status'] : null;
        $this->created_at   = !empty($data['created_at']) ? $data['created_at'] : null;
        $this->updated_at   = !empty($data['updated_at']) ? $data['updated_at'] : null;
      
    }
    
    // Add the following method:
    public function getArrayCopy()
    {
        return [
            'agent_id'      => $this->agent_id,
            'first_name'    => $this->first_name,
            'last_name'     => $this->last_name,
            'email'         => $this->email,
            'department'    => $this->department,
            'photo'         => $this->photo,
            'status'        => $this->status,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at
           
        ];
    }
   
}
