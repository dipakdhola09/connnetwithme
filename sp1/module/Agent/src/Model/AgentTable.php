<?php

namespace Agent\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class AgentTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    /*
     * Fetch all data from database
     */
    public function fetchAll()
    {
        return $this->tableGateway->select();
    }
    
    /*
     * Get Agent data
     */
    public function getAgentData($email,$password) {
        $password=md5($password);
        $rowset = $this->tableGateway->select(['email' => $email,'password' => $password]);
        $row = $rowset->current();
        return $row;
    }
}
