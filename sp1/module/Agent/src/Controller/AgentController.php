<?php
/**
 * @author Akshay <akshay.vyas@people-tree.com>
 * @package Agent Module
 * @name Agent 
 * @access Agent 
 * @version Live Support S.P.1
 */
namespace Agent\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AgentController extends AbstractActionController {
    // Add this property:
    private $table;
    
    /*
     * index 
     */
    public function indexAction() {
//         $this->ChatTable= $this->getEvent()
//                                ->getApplication()
//                                ->getServiceManager()
//                                ->get('Chat\Model\ChatTable');
//         return new ViewModel([
//           
//                'data' => $this->ChatTable->fetchAll(),
//        ]);
    }
    
    /*
     * dashboard initiate
     */
    public function chatAction() {
//        $layout = $this->layout();
//        $layout->setTemplate('layout/agentChat');
//        return new ViewModel();
    }
    
    // To do
    public function transferChatAction() {
        //to do
    }
}