<?php

namespace Auth\Controller;

use Auth\Model\SignupTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


// Add the following import statements at the top of the file:
use Auth\Form\SignupForm;
use Auth\Model\Signup;

//For mail send
use Zend\Mail\Message;

class SignupController extends AbstractActionController {

    // Add this property:
    private $table;

    // Add this constructor:
    public function __construct(SignupTable $table) {
        $this->table = $table;
    }

    public function indexAction() {
        //load form
        $form = new SignupForm();
        $form->get('submit')->setValue('Register');

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }


        //After we have saved the new album row, we redirect back to the list of albums using the Redirect controller plugin.
        return $this->redirect()->toRoute('signup');
    }
    
    public function addAction() {
        //We instantiate AlbumForm and set the label on the submit button to "Add". We do this here as we'll want to 
        //re-use the form when editing an album and will use a different label.
        
        //Load Form
        $form = new SignupForm();
        $form->get('submit')->setValue('Register');


        //If the request is not a POST request, then no form data has been submitted, and we need to display the form. 
        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        
        //to the form; additionally, we pass the submitted data from the request instance to the form.
        $signup = new Signup();
        
        //At this point, we know we have a form submission. We create an Album instance, and pass its input filter on 
        $form->setInputFilter($signup->getInputFilter());
        //unset filter
        $form->getInputFilter()->get('no_of_employee')->setRequired(FALSE);
        $form->getInputFilter()->get('plan')->setRequired(FALSE);
        $form->setData($request->getPost());
        
        //If form validation fails, we want to redisplay the form. At this point, the form contains information 
        //about what fields failed validation, and why, and this information will be communicated to the view layer.
        if (!$form->isValid()) {
            return ['form' => $form];
        }


        //check validation
        if ($form->isValid()) {
                       
            //If the form is valid, then we grab the data from the form and store to the model using saveUser().
            $signup->exchangeArray($form->getData());
            $this->table->saveUser($signup);
            
            //call send mail function and pass form data
            $this->sendConfirmationEmail($signup);
        }

        //After we have saved the new album row, we redirect to the success using the Redirect controller plugin.
        return $this->redirect()->toRoute('signup', ['action' => 'success']);
    }
    
    public function successAction() {
        //load Success page after signup
    }

    
    /*
     * send mail
     * @signup :- form data
     */
    public function sendConfirmationEmail($signup)
    {
        
        //encode email
        $encrypted = strtr(base64_encode($signup->email), '+=', '-_');
        
        //get mail configuration
        $transport = $this->getEvent()->getApplication()->getServiceManager()->get('mail.transport');
	
        //Message object
        $message = new Message();
	
        $this->getRequest()->getServer();  //Server vars
	
        //add fields into mail
        $message->addTo($signup->email)
			->addFrom('dev.iwebquare@gmail.com')
			->setSubject('New Subscription - Connect with me')
			->setBody("Hello!
                            Thanks for signing up to hear from us about Connect With Me. Please confirm your
                            subscription so you can start chat application code from us:

                            Confirm Subscription {"."http://localhost/connectwithme/public/signup/confirmEmail/".$encrypted."}
                            
                            If you didn't sign up for this, just ignore this email.

                            Best wishes,
                            Connect with me Team."
                                );
	
        //mail sent
        $transport->send($message);
    }
    
    /*
     * Confirma email for active user
     */
    public function confirmEmailAction() {
        
        //fetch segment
        $id = $this->params()->fromRoute('id', 0);
        
        //decode email
        $email = strtr(base64_decode($id), '+=', '-_');
        
        try {
                //get user data by email
                $user       = $this->table->getUserByEmail($email);
                
                //fetch id from user data
                $usr_id     = $user->user_id;
                
                //update user Active
                $this->table->activateUser($usr_id);
            
        } catch (\Exception $e) {
            //redirect signup page
            return $this->redirect()->toRoute('signup', ['action' => 'add']);
        }
        //redirect Confirmation success route
        return $this->redirect()->toRoute('signup', ['action' => 'confirmationSuccess']);
    
    }
    public function confirmationSuccessAction() {
        //load confirmation success page
    }
    
    
}
