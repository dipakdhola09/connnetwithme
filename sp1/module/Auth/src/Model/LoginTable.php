<?php

/**
 * @author Akshay <akshay.vyas@people-tree.com>
 * @package User
 * @name Model User
 * @access public
 * @version Live Support S.P.1
 */

namespace Auth\Model;

use RuntimeException;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGatewayInterface;

class LoginTable {

    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway) {
        $this->tableGateway = $tableGateway;
        //print_r($this->tableGateway);exit;
    }

    /*
     * fetch all data from database
     */

    public function fetchAll() {
        return $this->tableGateway->select();
    }

    /*
     * Get User data
     */

    public function getUserdata($email, $password) {
        $rowset = $this->tableGateway->select(['email' => $email, 'password' => $password, 'confirm_email' => 1]);
        $row = $rowset->current();
        return $row;
    }

}
