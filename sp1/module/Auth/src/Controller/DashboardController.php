<?php
/**
 * @author Akshay <akshay.vyas@people-tree.com>
 * @package Authorization
 * @name Dshboard
 * @access public
 * @version Live Support S.P.1
 */
namespace Auth\Controller;

use Zend\Session\Container;
use Zend\Mvc\Controller\AbstractActionController;

class DashboardController extends AbstractActionController {
    
    // Add this property:
    private $table;
    private $session;
    // Add this constructor:
    
    public function indexAction() {
        
    }
}