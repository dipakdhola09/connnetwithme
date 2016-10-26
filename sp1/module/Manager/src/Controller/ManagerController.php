<?php
/**
 * @author Akshay <akshay.vyas@people-tree.com>
 * @package Manager Module
 * @name Manager
 * @access Manager 
 * @version Live Support S.P.1
 */


namespace Manager\Controller;
use Manager\Model\ManagerTable;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Json\Json;
use Manager\Model\Manager;
use Manager\Form\AgentForm;
use Zend\File\Transfer\Adapter;
use Zend\Session\Container;

//For mail send
use Zend\Mail\Message;

/**
 * Manager Controller
 */
class ManagerController extends AbstractActionController {

    // Add this property:
    private $table;
    private $session;

    // Add this constructor:
    public function __construct(ManagerTable $table) {
        $this->table = $table;
        $this->session = new Container('base');
    }

    /**
     * Default Action
     */
    public function indexAction() {
        //to do
    }

    /**
     * agent Setup
     * @return type
     */
    public function agentSetupAction() {
        
        //Load Form
        $form = new AgentForm();
        $form->get('submit')->setValue('Add Agent');


        //If the request is not a POST request, then no form data has been submitted, and we need to display the form. 
        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        $agent = new Manager();
        
        //At this point, we know we have a form submission. We create an Album instance, and pass its input filter on 
        $form->setInputFilter($agent->getInputFilter());
        //unset filter
        $form->getInputFilter()->remove('department');
        
        $post_data = array_merge_recursive(
                $request->getPost()->toArray(), $request->getFiles()->toArray()
        );
        
        
        $form->setData($post_data);        //print_r($form->getInputFilter());exit;
        
        //check form validation
        if (!$form->isValid()) {
            return ['form' => $form];
        }
        
        //check form execute
        if ($form->isValid()) {

            //If the form is valid, then we grab the data from the form 
            //Generate encrypt & Random Password
            $pass = mt_rand(10000000, 99999999);            
            $password['password'] = md5($pass);

            //Store file in directory
            $adapter = new \Zend\File\Transfer\Adapter\Http();
            
            //Set Local path Uploading agent //TO DO
            $adapter->setDestination('D:\\upload');
            
            //set file info
            $files = $adapter->getFileInfo();
            foreach ($files as $fieldname => $fileinfo) {
                $adapter->receive($fileinfo['name']);
            }

            //add manager id
            $manager['manager_id'] = $this->session->offsetGet('user_id');

            //save agent
            $agent->exchangeArray($post_data, $password, $manager);
            $this->table->saveAgent($agent);

            //get mail configuration
            $transport = $this->getEvent()->getApplication()->getServiceManager()->get('mail.transport');

            //Message object
            $message = new Message();

            $this->getRequest()->getServer();  //Server vars
            //add fields into mail
            $message->addTo($agent->email)
                    ->addFrom('dev.livesuppport@gmail.com')
                    ->setSubject('Agent - Live Support Credentials')
                    ->setBody("Hello!
                        Congratulations!
                        You are all set for Live Support. Your Live Support credentials fall as under.
                        
                        URL: ".PUBLIC_PATH."login
                        Access Code : $pass
                        
                        Thanks 
                        Team - Live Support"
            );

            //mail sent
            $transport->send($message);

            return $this->redirect()->toRoute('manager', ['action' => 'agentSetup']);
        }
    }

    /**
     * To get Agent List
     */
    public function getAgentAction() {

        $this->AgentTable = $this->getEvent()
                ->getApplication()
                ->getServiceManager()
                ->get('Agent\Model\AgentTable');

        $data = $this->AgentTable->fetchAll();

        //json response
        echo Json::encode($data);
        exit();
    }
    
    /**
     * chat setup
     */
    public function chatSetupAction() {
        //to do
    }

    /**
     * Completed chat
     */
    public function completedChatAction() {
        //to do
    }

    /**
     * Chat Details
     */
    public function chatDetailAction() {
        //to do
    }

    /**
     * accout setting
     */
    public function accountSettingsAction() {
        //to do
    }

    /**
     * All Chat
     */
    public function allChatAction() {
        //to do
    }

    

}
