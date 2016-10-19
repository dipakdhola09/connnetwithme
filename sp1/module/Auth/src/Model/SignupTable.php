<?php

namespace Auth\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class SignupTable
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
    public function getUser($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['user_id' => $id]);
        
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
     * Save User data
     */
    public function saveUser(Signup $signup)
    {
        $data = [
            'first_name' => $signup->first_name,
            'last_name' => $signup->last_name,
            'company' => $signup->company,
            'email' => $signup->email,
            'password'  => $signup->password,
            'phone' => $signup->phone.'-'.$signup->ext,
            'no_of_employee' => $signup->no_of_employees,
            'plan'  => $signup->plans,
            'user_type' => $signup->user_type,
            'status' => $signup->status,
            //'confirm_email' => $signup->confirm_email,
            'created_at' => $signup->created_at,
            'updated_at' => $signup->updated_at,
        ];
        //print_r($data);exit;
        $id = (int) $signup->user_id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        
        $this->tableGateway->update($data, ['user_id' => $id]);
    }
    
    
    /*
     * Get uset data by email id
     */
    public function getUserByEmail($email)
    {
         $rowset = $this->tableGateway->select(['email' => $email]);
        
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $email
            ));
        }

        return $row;
    }
    
    /*
     * update user status
     */
    public function activateUser($id)
    {
		$data['confirm_email'] = 1;
		$this->tableGateway->update($data, array('user_id' => (int)$id));
    }	
   
}
