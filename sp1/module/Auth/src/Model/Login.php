<?php

/**
 * @author Akshay <akshay.vyas@people-tree.com>
 * @package User
 * @name Model User - Structure
 * @access public
 * @version Live Support S.P.1
 */

namespace Auth\Model;

use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\EmailAddress;
use Zend\Validator\StringLength;

class Login {

    public $user_id;
    public $email;
    public $password;
    public $user_type;
    public $confirm_email;
    public $created_at;
    // Add this property:
    private $inputFilter;

    public function exchangeArray(array $data) {
        $this->user_id = !empty($data['user_id']) ? $data['user_id'] : null;
        $this->email = !empty($data['email']) ? $data['email'] : null;
        $this->first_name = !empty($data['first_name']) ? $data['first_name'] : null;
        $this->last_name = !empty($data['last_name']) ? $data['last_name'] : null;
        $this->password = !empty($data['password']) ? $data['password'] : null;
        $this->confirm_email = !empty($data['confirm_email']) ? $data['confirm_email'] : null;
        $this->user_type = !empty($data['user_type']) ? $data['user_type'] : null;
        $this->created_at = !empty($data['created_at']) ? $data['created_at'] : null;
    }

    // Add the following method:
    public function getArrayCopy() {
        return [
            'user_id' => $this->user_id,
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'password' => $this->password,
            'user_type' => $this->user_type,
            'confirm_email' => $this->confirm_email,
            'created_at' => $this->created_at,
        ];
    }

    /*
     * Add the following methods: 
     * set Inputfilter
     */

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new DomainException(sprintf(
                '%s does not allow injection of an alternate input filter', __CLASS__
        ));
    }

    /*
     * Get Input Filter for form element
     */

    public function getInputFilter() {
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
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 5,
                        'max' => 40,
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'user_type',
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



        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }

}
