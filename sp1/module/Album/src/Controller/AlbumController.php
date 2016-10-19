<?php

namespace Album\Controller;

// Add the following import:
use Album\Model\AlbumTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

// Add the following import statements at the top of the file:
use Album\Form\AlbumForm;
use Album\Model\Album;

class AlbumController extends AbstractActionController {

    // Add this property:
    private $table;

    // Add this constructor:
    public function __construct(AlbumTable $table) {
        $this->table = $table;
    }

    public function indexAction() {

        return new ViewModel([
            'albums' => $this->table->fetchAll(),
        ]);
    }

    public function addAction() {
        
        //We instantiate AlbumForm and set the label on the submit button to "Add". We do this here as we'll want to 
        //re-use the form when editing an album and will use a different label.
        $form = new AlbumForm();
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
        $album = new Album();
        $form->setInputFilter($album->getInputFilter());
        $form->setData($request->getPost());

        //If form validation fails, we want to redisplay the form. At this point, the form contains information 
        //about what fields failed validation, and why, and this information will be communicated to the view layer.
        if (!$form->isValid()) {
            return ['form' => $form];
        }

        //If the form is valid, then we grab the data from the form and store to the model using saveAlbum().
        $album->exchangeArray($form->getData());
        $this->table->saveAlbum($album);
        
        //After we have saved the new album row, we redirect back to the list of albums using the Redirect controller plugin.
        return $this->redirect()->toRoute('album');
    }

    public function editAction() {
        
         $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('album', ['action' => 'add']);
        }

        // Retrieve the album with the specified id. Doing so raises
        // an exception if the album is not found, which should result
        // in redirecting to the landing page.
        try {
            $album = $this->table->getAlbum($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('album', ['action' => 'index']);
        }

        $form = new AlbumForm();
        $form->bind($album);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($album->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->saveAlbum($album);

        // Redirect to album list
        return $this->redirect()->toRoute('album', ['action' => 'index']);
        
    }

    public function deleteAction() {
        
    }

}
