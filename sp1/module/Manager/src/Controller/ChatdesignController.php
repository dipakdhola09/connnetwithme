<?php

/**
 * @author Akshay <akshay.vyas@people-tree.com>
 * @package Manager Module
 * @name Chatdesign 
 * @access Manager 
 * @version Live Support S.P.1
 */

namespace Manager\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Manager\Form\ChatdesignForm;
use Manager\Model\Chatdesign;
use Manager\Model\ChatdesignTable;
use Zend\Session\Container;

class ChatdesignController extends AbstractActionController {

    private $table;
    private $session;

    // Add this constructor:
    public function __construct(ChatdesignTable $table) {
        $this->table = $table;
        $this->session = new Container('base');
    }

    public function chatDesignAction() {
        $form = new ChatdesignForm();
        $form->get('submit')->setValue('Save');

        $request = $this->getRequest();
        $manager_id = $this->session->offsetget('user_id');
        $data = $this->table->getChatdesignData($manager_id);
        if ($data != "") {
            $form->setData((array) $data);
        }
        if (!$request->isPost()) {

            return ['form' => $form];
        }

        //At this point, we know we have a form submission. We create an chatbutton instance, and pass its input filter on 
        $chatdesign = new Chatdesign();

        $form->setInputFilter($chatdesign->getInputFilter());

        $form->getInputFilter()->remove('font');
        $form->getInputFilter()->remove('button_dimension');
        $form->getInputFilter()->remove('button_location');
        $form->getInputFilter()->remove('open_font');
        $form->getInputFilter()->remove('open_desktop_dimension');
        $form->getInputFilter()->remove('open_mobile_dimension');
        $form->getInputFilter()->remove('open_tablet_dimension');
        $form->getInputFilter()->remove('pro_font');
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form];
        }

        if ($form->isValid()) {
            //If the form is valid, then we grab the data from the form and store to the model using saveUser().
            $chatdesign->exchangeArray((array) $request->getPost());
            $chatdesign_data = $this->table->fetchAll();
            $this->table->saveChatdesign($chatdesign, $chatdesign_data);

            return $this->redirect()->toRoute('chatdesign');
        }
    }

}
