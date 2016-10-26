<?php
/**
 * @author Akshay <akshay.vyas@people-tree.com>
 * @package Authorization
 * @name Forgot Password
 * @access public
 * @version Live Support S.P.1
 */

namespace Auth\Controller;

use Auth\Form\ForgotpasswordForm;
use Auth\Form\ResetpasswordForm;
use Auth\Model\Forgot;
use Auth\Model\ForgotTable;
use Zend\Mvc\Controller\AbstractActionController;

//For mail send
use Zend\Mail\Message;

class ForgotpasswordController extends AbstractActionController {
    
    // Add this property:
    private $table;

    // Add this constructor:
    public function __construct(ForgotTable $table) {
        $this->table = $table;
    }
    
    /**
     * Default Index Action
     * @return type
     */
    public function indexAction() {
        
        $form = new ForgotpasswordForm();
        $form->get('submit')->setValue('Submit');
        
        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }
        
        //redirect
        return $this->redirect()->toRoute('forgotpassword');
    }
    
    /**
     * Check Email
     * @return type
     */
    public function checkemailAction() {
        
        $form = new ForgotpasswordForm();
        
        $form->get('submit')->setValue('Submit');

        //If the request is not a POST request, then no form data has been submitted, and we need to display the form. 
        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }
        
        //to the form; additionally, we pass the submitted data from the request instance to the form.
        $forgot = new Forgot();
        
        //At this point, we know we have a form submission. 
        $form->setInputFilter($forgot->getInputFilter());
        $form->getInputFilter()->get('password')->setRequired(FALSE);
        $form->getInputFilter()->get('confirm_password')->setRequired(FALSE);
        
        $form->setData($request->getPost());
        
        if (!$form->isValid()) {
            return ['form' => $form];
        }

        //check validation
        if ($form->isValid()) {
            
            $forgot->exchangeArray($form->getData());
            
            $encrypted = strtr(base64_encode($forgot->email), '+=', '-_');
            
            //get mail configuration
            $transport = $this->getEvent()->getApplication()->getServiceManager()->get('mail.transport');
	
            //Message object
            $message = new Message();
	
            $this->getRequest()->getServer();  //Server vars
	
            //add fields into mail - local environment - TEST
            $message->addTo($forgot->email)
			->addFrom('dev.livesuppport@gmail.com')
			->setSubject('Forgot Password - Live Support')
			->setBody("Hello!
                            We got a request to reset your Live Support Password.
                            
                            Reset Password ".PUBLIC_PATH."forgotpassword/resetpassword/".$encrypted."
                            
                            If you didn't want to reset your password, just ignore this email.

                            Best wishes,
                            Live Support Team."
                            );
	
            //mail sent
            $transport->send($message);
        }
        
        //redirect
        return $this->redirect()->toRoute('login');
    }
    
    /**
     * Reset Password
     * @return type
     */
    public function resetpasswordAction() {
        
        //fetch segment
        $id = $this->params()->fromRoute('id', 0);
        $email = strtr(base64_decode($id), '+=', '-_');

        
        $form = new ResetpasswordForm();
        $form->get('submit')->setValue('Reset');
        $form->get('email')->setValue($email);


        //If the request is not a POST request, then no form data has been submitted, and we need to display the form. 
        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }
        
        if($request->isPost()) {
        
        //to the form; additionally, we pass the submitted data from the request instance to the form.
        $reset = new Forgot();
        
        //At this point, we know we have a form submission. We create an Album instance, and pass its input filter on 
        $form->setInputFilter($reset->getInputFilter());
        $form->getInputFilter()->get('email')->setRequired(FALSE);
        $form->setData($request->getPost());
        
            if (!$form->isValid()) {
                return ['form' => $form];
            }
        
            //check validation
            if ($form->isValid()) {

                $email=$request->getPost('email');

                $password['password']=$request->getPost('password');

                //If the form is valid, then we grab the data from the form and store to the model using saveUser().
                $this->table->updatepassword($email,$password);

                return $this->redirect()->toRoute('login');

            }
        }
        
    }
   
}
 
