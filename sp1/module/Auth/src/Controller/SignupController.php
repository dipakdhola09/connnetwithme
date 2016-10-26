<?php

/**
 * @author Akshay <akshay.vyas@people-tree.com>
 * @package Authorization
 * @name Sign up 
 * @access public
 * @version Live Support S.P.1
 */

namespace Auth\Controller;

use Auth\Model\SignupTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
// Add the following import statements at the top of the file:
use Auth\Form\SignupForm;
use Auth\Model\Signup;
use Zend\Mvc\Plugin\FlashMessenger;
//For mail send
use Zend\Mail\Message;

/**
 * Signup Controller
 */
class SignupController extends AbstractActionController {

    // Add this property:
    private $table;

    // Add this constructor:
    public function __construct(SignupTable $table) {
        $this->table = $table;
    }

    /**
     * default Index action
     * @return type
     */
    public function indexAction() {

        //load form
        $form = new SignupForm();
        $form->get('submit')->setValue('Register');

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        //we redirect back to signup form.
        return $this->redirect()->toRoute('signup');
    }

    /**
     * Signup Add action
     * @return type
     */
    public function addAction() {

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

        //At this point, we know we have a form submission. We create an Signup instance, and pass its input filter on 
        $form->setInputFilter($signup->getInputFilter());

        //set form data
        $form->getInputFilter()->remove('no_of_employee');
        $form->getInputFilter()->remove('plan');
        $form->setData($request->getPost());


        //If form validation fails, we want to redisplay the form. At this point, the form contains information 
        //about what fields failed validation, and why, and this information will be communicated to the view layer.
        if (!$form->isValid()) {
            return ['form' => $form];
        }

        if ($form->isValid()) {

            //If the form is valid, then we grab the data from the form and store to the model using saveUser().
            $signup->exchangeArray($form->getData());

            $this->table->saveUser($signup);

            //call send mail function and pass form data
            $this->sendConfirmationEmail($signup);
        }

        //After we have saved the new user, we redirect to the success using the Redirect controller plugin.
        return $this->redirect()->toRoute('signup', ['action' => 'success']);
    }

    /**
     * Success action
     */
    public function successAction() {
        //load Success page after signup
    }

    /*
     * send mail
     * @signup :- form data
     */

    public function sendConfirmationEmail($signup) {

        //encode email
        $encrypted = strtr(base64_encode($signup->email), '+=', '-_');

        //get mail configuration
        $transport = $this->getEvent()->getApplication()->getServiceManager()->get('mail.transport');

        //Message object
        $message = new Message();

        $this->getRequest()->getServer();  //Server vars
        //add fields into mail // TEST SERVER //local environment
        $message->addTo($signup->email)
                ->addFrom('dev.livesuppport@gmail.com')
                ->setSubject('New Subscription - Thanks for registering with Live Support')
                ->setBody("Hello " . $signup->first_name . " " . $signup->last_name . ", " . "
                            Thanks for registering with Live Support!

                            In order to have an access of Live Support please confirm your email address -

                            " . PUBLIC_PATH ."signup/confirmEmail/" . $encrypted . "
                                
                            Below is the code that you require to install at your company's website -
                            
                            <div id='demo'></div>
                            <script src='http://bit.ly/2etBlAr'></script>
                            <script src='http://bit.ly/2etKA5n'></script>
                            <script type='text/javascript'>$('#viewclick').click(function(){ $('.chat-btn').hide(); $('.chat-box').show(); });</script>

                            If you didn't sign up for Live Support, kindly ignore this email.                            

                            Thanks for choosing Live Support, Appreciated!

                            Team - Live Support"
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
            $user = $this->table->getUserByEmail($email);

            //fetch id from user data
            $usr_id = $user->user_id;

            //update user Active
            $this->table->activateUser($usr_id);
        } catch (\Exception $e) {
            //redirect signup page
            return $this->redirect()->toRoute('signup', ['action' => 'add']);
        }
        //redirect Confirmation success route
        return $this->redirect()->toRoute('signup', ['action' => 'confirmationSuccess']);
    }

    /**
     * Confirmation - Success
     */
    public function confirmationSuccessAction() {
        //load confirmation success page
    }

}
