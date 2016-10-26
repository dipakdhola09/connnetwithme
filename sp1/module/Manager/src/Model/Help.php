<?php

namespace Manager\Model;

use DomainException;

//use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


class Help
{
    public $department_id;
    public $department_name;
    public $url;
    
    // Add this property:
    private $inputFilter;

    public function exchangeArray(array $data)
    {
        $this->department_id         = !empty($data['department_id']) ? $data['department_id'] : null;
        $this->department_name  = !empty($data['department_name']) ? $data['department_name'] : null;
        $this->url  = !empty($data['url']) ? $data['url'] : null;
    }
    
    // Add the following method:
    public function getArrayCopy()
    {
        return [
            'department_id'     => $this->department_id,
            'department_name'   => $this->department_name,
            'url'               => $this->url,
           
        ];
    }
    
   
}
