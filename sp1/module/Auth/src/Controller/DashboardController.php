<?php
namespace Auth\Controller;

//use Auth\Form\LoginForm;
//use Auth\Model\Login;
//use Auth\Model\LoginTable;
//use Zend\Mvc\Controller\PluginManager;
//use Zend\Mvc\Plugin\FlashMessenger;
use Zend\Session\Container;
use Zend\Mvc\Controller\AbstractActionController;

class DashboardController extends AbstractActionController {
    // Add this property:
    private $table;
    private $session;
    // Add this constructor:
//    public function __construct() {
//        $this->session=new Container('base');
//        if(!$this->session->offsetGet('id'))
//        {
//            return $this->redirect()->toRoute('login');
//        }
//    }
    
    public function indexAction() {
        
    }
}