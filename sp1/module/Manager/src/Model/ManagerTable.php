<?php

namespace Manager\Model;

use RuntimeException;
use Agent\Model\Agent;
use Zend\Db\TableGateway\TableGatewayInterface;

class ManagerTable
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
    public function getManager($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }
   
    /*
     * Save Agent data
     */
    public function saveAgent(Manager $agent)
    {
        //print_r($agent);exit;
        $data = [
            'manager_id' => $agent->manager_id,
            'first_name' => $agent->first_name,
            'last_name' => $agent->last_name,
            'email' => $agent->email,
            'password' => $agent->password,
            'department' =>$agent->department,
            'photo' => $agent->photo['name'],
            'status' => $agent->status,
            'created_at' => $agent->created_at,
            'updated_at' => $agent->updated_at,
        ];
        //print_r($data);exit;
        $id = (int) $agent->agent_id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

    }
}
