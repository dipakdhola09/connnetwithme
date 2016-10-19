<?php

namespace Auth\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class ForgotTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
        //print_r($this->tableGateway);exit;
    }
    
    /*
     * fetch all data from database
     */
    public function fetchAll()
    {
        return $this->tableGateway->select();
    }
    
    /*
     * update password by email id
     */
    public function updatepassword($email,$password)
    {
         $this->tableGateway->update($password,['email' => $email]);
        
    }
    
}
