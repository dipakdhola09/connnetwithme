<?php

namespace Manager\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class HelpTable
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
     * Save Agent data
     */
    public function saveData(Help $help)
    {
        $data = [
            'department_name'   => $help->department_name,
            'url'               => $help->url,
        ];
        //print_r($data);exit;
        $id = (int) $help->department_id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }
        $this->tableGateway->update($data, ['department_id' => $id]);

    }
    
    public function deleteData($department_id){
        $this->tableGateway->delete(['department_id' => $department_id]);
    }
}
