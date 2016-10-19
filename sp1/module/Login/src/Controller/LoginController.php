<?php

namespace Login\Controller;
 
// Add the following import:
use Login\Model\LoginTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

// Add the following import statements at the top of the file:
use Login\Form\LoginForm;
use Login\Model\Login;
 
class LoginController extends AbstractActionController
{
    // Add this property:
    private $table;

    // Add this constructor:
    public function __construct(LoginTable $table) {
        $this->table = $table;
    }

    public function indexAction() {

       //We instantiate AlbumForm and set the label on the submit button to "Add". We do this here as we'll want to 
        //re-use the form when editing an album and will use a different label.
        $form = new LoginForm();
        $form->get('submit')->setValue('Login');


        //If the request is not a POST request, then no form data has been submitted, and we need to display the form. 
        //zend-mvc allows you to return an array of data instead of a view model if desired; if you do, 
        //the array will be used to create a view model.
        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        
        //After we have saved the new album row, we redirect back to the list of albums using the Redirect controller plugin.
        return $this->redirect()->toRoute('login');
       
        
    }
    
    public function addAction(){
        
      //We instantiate AlbumForm and set the label on the submit button to "Add". We do this here as we'll want to 
        //re-use the form when editing an album and will use a different label.
        $form = new LoginForm();
        $form->get('submit')->setValue('Add');


        //If the request is not a POST request, then no form data has been submitted, and we need to display the form. 
        //zend-mvc allows you to return an array of data instead of a view model if desired; if you do, 
        //the array will be used to create a view model.
        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        //At this point, we know we have a form submission. We create an Album instance, and pass its input filter on 
        //to the form; additionally, we pass the submitted data from the request instance to the form.
        $login = new Login();
        $form->setInputFilter($login->getInputFilter());
        $form->setData($request->getPost());

        //If form validation fails, we want to redisplay the form. At this point, the form contains information 
        //about what fields failed validation, and why, and this information will be communicated to the view layer.
        if (!$form->isValid()) {
            return ['form' => $form];
        }
        
        if ($form->isValid())
            {
            
            $login->exchangeArray($form->getData());
            
                $result = $this->table->checkLogin($login);
                
                
                if ($result) {
                    $redirect = 'success';                   
                    
                }
            }        

        //If the form is valid, then we grab the data from the form and store to the model using saveAlbum().
        $login->exchangeArray($form->getData());
        $this->table->saveUser($login);
        
        //After we have saved the new album row, we redirect back to the list of albums using the Redirect controller plugin.
        return $this->redirect()->toRoute('login');
    }
    
   
}