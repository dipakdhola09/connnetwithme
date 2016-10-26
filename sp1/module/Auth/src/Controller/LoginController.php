<?php
/**
 * @author Akshay <akshay.vyas@people-tree.com>
 * @package Authorization
 * @name Login 
 * @access public
 * @version Live Support S.P.1
 */

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
    
    /**
     * Class default Index action
     * @return type
     */
    public function indexAction() {
        
        //Load form
        $form = new LoginForm();
        $form->get('submit')->setValue('Login');
        
        //If the request is not a POST request, then no form data has been submitted, and we need to display the form. 
        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }
        
        //we redirect back to the login.
        return $this->redirect()->toRoute('login');
        
    }
    
    /**
     * Check Login
     * @return type
     */
    public function checkloginAction() {
        
        //Load form
        $form = new LoginForm();
        $form->get('submit')->setValue('Login');
        
        //If the request is not a POST request, then no form data has been submitted, and we need to display the form. 
        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }
        
        $login=new Login();
        //set filter
        $form->setInputFilter($login->getInputFilter());
        $form->getInputFilter()->remove('user_type');
        $form->setData($request->getPost());
        
        //check validation
        if (!$form->isValid()) {
            return ['form' => $form];
        }
        //get post data
        //$post_data=$request->getPost();        
        $email=$request->getPost('email');
        $password = $request->getPost('password');
        $user_type = $request->getPost('user_type');
        
        //check email and password for login = AGENT
        if($user_type == "Agent") {
            $this->AgentTable = $this->getEvent()
                            ->getApplication()
                            ->getServiceManager()
                            ->get('Agent\Model\AgentTable');
            $data = $this->AgentTable->getAgentdata($email,$password);
            
            //Check email & Password
            if($data != "") {
               
                //set agent session
                $this->session->offsetSet('agent_id', $data->agent_id);
                $this->session->offsetSet('first_name', $data->first_name);
                $this->session->offsetSet('last_name', $data->last_name);
                return $this->redirect()->toRoute('agent');
            }
            else {
                $this->flashMessenger()->addMessage('Your Email id and password is invalid.');
                return $this->redirect()->toRoute('login');
            }
            
        } else {
        
            //get eamil & password
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
                //Set user id into session
                $this->session->offsetSet('user_id', $data->user_id);
                $this->session->offsetSet('first_name', $data->first_name);
                $this->session->offsetSet('last_name', $data->last_name);

                //Redirect user type accordingly value
                if($data->user_type == 'Manager') {
                    return $this->redirect()->toRoute('manager');
                }
                if($data->user_type == 'Admin') {
                    return $this->redirect()->toRoute('admin');
                }
            
            } else {
            
                //show flash message about not valid
                $this->flashMessenger()->addMessage('Your Email id and password is invalid.');
                return $this->redirect()->toRoute('login');
            }
        }
    }
    
    /**
     * Logout Action
     * @return type
     */    
    public function logoutAction() {
        $this->session->offsetUnset('id');
        return $this->redirect()->toRoute('login');
        
    }
}
