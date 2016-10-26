<?php
/**
 * @author Akshay <akshay.vyas@people-tree.com>
 * @package Authorization
 * @name Sign up 
 * @access public
 * @version Live Support S.P.1
 */

namespace Chatpreview\Controller;
//use Auth\Model\SignupTable;
use Zend\Mvc\Controller\AbstractActionController;
use Manager\Model\Chatdesign;
use Manager\Model\ChatdesignTable;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

/**
 * Signup Controller
 */
class ChatpreviewController extends AbstractActionController {
    
    // Add this property:
    private $table;
    private $session;

    // Add this constructor:
    public function __construct(ChatdesignTable $table) {
        $this->table = $table;
        $this->session=new Container('base');
    }
    
    /**
     * default Index action
     * @return type
     */
    public function indexAction() {
        $manager_id  =1;
        //$manager_id=$this->session->offsetget('user_id');
        $data=$this->table->getChatdesignData($manager_id);
        $this->layout()->setVariable('data', $data);
        return new ViewModel(['data' => $data]);
    }
}

