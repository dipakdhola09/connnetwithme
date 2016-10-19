<?php

namespace Login\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class LoginTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }
    
    public function saveUser(Login $login)
    {
        $data = [
            'username' => $login->username,
            'password'  => $login->password,
        ];

        $id = (int) $login->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        
        $this->tableGateway->update($data, ['id' => $id]);
    }
    
    public function checkLogin(Login $login)
    {
        echo $username = $login->username;
        $data = [
            'username' => $login->username,
            'password'  => $login->password,
        ];
        
        $rowset = $this->tableGateway->select(['id' => 1]);
        $row = $rowset->current();
        
        //var_dump($row);exit;
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
        
    }

    
}