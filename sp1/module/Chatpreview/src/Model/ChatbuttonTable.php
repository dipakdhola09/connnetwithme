<?php

namespace Chatpreview\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class ChatbuttonTable
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
     * Get user data from id
     */
    public function getChatbuttondata($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['manager_id' => $id]);
        
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }
   
}
