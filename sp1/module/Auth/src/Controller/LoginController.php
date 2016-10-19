<?php

namespace Auth\Controller;

use Auth\Form\LoginForm;
use Auth\Model\Login;
use Auth\Model\LoginTable;
use Zend\Session\Container;

//use Zend\Mvc\Controller\PluginManager;
use Zend\Mvc\Plugin\FlashMessenger;
use Zend\Mvc\Controller\AbstractActionController;

class LoginController extends AbstractActionController {
    // Add this property:
    private $table;
    private $session;
    
    // Add this constructor:
    public function __construct(LoginTable $table) {
        $this->table = $table;
        $this->session=new Container('base');
    }
    
    public function indexAction() {
        //Load form
        $form = new LoginForm();
        $form->get('submit')->setValue('Login');
        
        //If the request is not a POST request, then no form data has been submitted, and we need to display the form. 
        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }
        
        //After we have saved the new album row, we redirect back to the list of albums using the Redirect controller plugin.
        return $this->redirect()->toRoute('login');
        
    }
    
    public function checkloginAction() {
        
        $request = $this->getRequest();
        
        //get post data
        $post_data=$request->getPost();
        
        $email=$post_data['email'];
        $password = $post_data['password'];
        
        if (!$request->isPost()) {
            return $this->redirect()->toRoute('login');
        }
        
        //check email and password for login
        if($email != '') {
            
        $data = $this->table->getUserdata($email,$password);       
        if($data != "") {        
                //get trial Expiry date
                $trial_expiry= date('Y-m-d',  strtotime($data->created_at.' + 15 days'));
                $current_date= date('Y-m-d');
                
                //check expiry date is over or not
                if($current_date > $trial_expiry) {
                    $this->flashMessenger()->addMessage('Your Trial period is expired');
                    return $this->redirect()->toRoute('login');
                }
                $this->session->offsetSet('id', $data->user_id);
                if($data->user_type == 'Manager') {
                    return $this->redirect()->toRoute('manager');
                }
                
                if($data->user_type == 'Agent') {
                    return $this->redirect()->toRoute('agent');
                }
                
                if($data->user_type == 'Admin') {
                    return $this->redirect()->toRoute('admin');
                }
                //set session
                $this->session->offsetSet('id', $data->user_id);
                return $this->redirect()->toRoute('dashboard');
        }
        else {
                $this->flashMessenger()->addMessage('Your Email id and password is not valid');
                return $this->redirect()->toRoute('login');
        }
        }
        else {
                //set flash message
                $this->flashMessenger()->addMessage('Your Email id and password is not valid');
                return $this->redirect()->toRoute('login');
        }
        
    }
    
    public function logoutAction() {
        $this->session->offsetUnset('id');
        return $this->redirect()->toRoute('login');
        
    }
}
