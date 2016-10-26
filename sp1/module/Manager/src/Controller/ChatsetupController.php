<?php

/**
 * @author Akshay <akshay.vyas@people-tree.com>
 * @package Chatsetup Module
 * @name chat
 * @access Manager 
 * @version Live Support S.P.1
 */

namespace Manager\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Manager\Model\Help;
use Manager\Model\HelpTable;
use Zend\Json\Json;
use Manager\Model\Chatcampaign;
use Manager\Model\ChatcampaignTable;

//use Zend\View\Model\JsonModel;
class ChatsetupController extends AbstractActionController {

    private $table;

    public function __construct(HelpTable $table) {
        $this->table = $table;
    }
    /**
     * Chat Setup
     * @return type
     */
    public function chatSetupAction() {
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return;
        } else {
            $help = new Help();
            $data = (array) $request->getPost();
            $help->exchangeArray($data);
            $this->table->saveData($help);

            echo Json::encode($help);
            return;
        }
    }

    /**
     * Get Help - Department 
     */
    public function getDepartmentAction() {

        $data = $this->table->fetchAll();

        echo Json::encode($data);
        exit();
    }

    /**
     * Delete Help - Department
     */
    public function deleteDepartmentAction() {
        $request = $this->getRequest();
        $data = (array) $request->getPost();
        $this->table->deleteData($data['department_id']);

        $this->getDepartmentAction();
    }

    /**
     * Get Chat Campaing
     */
    public function getChatcampaignAction() {
        $this->ChatcampaignTable = $this->getEvent()
                ->getApplication()
                ->getServiceManager()
                ->get(\Manager\Model\ChatcampaignTable::class);
        $data = $this->ChatcampaignTable->fetchAll();

        echo Json::encode($data);
        exit();
    }
    
    /**
     * Save chat Campaign
     */
    public function saveChatcampaignAction() {
        $this->ChatcampaignTable = $this->getEvent()
                ->getApplication()
                ->getServiceManager()
                ->get(\Manager\Model\ChatcampaignTable::class);
        $request = $this->getRequest();
        $chatcampaign = new Chatcampaign();
        $data = (array) $request->getPost();
        $chatcampaign->exchangeArray($data);
        $this->ChatcampaignTable->saveData($chatcampaign);

        $this->getChatcampaignAction();
    }

    /**
     * Delete Chat Campaing
     */
    public function deleteChatcampaignAction() {
        $this->ChatcampaignTable = $this->getEvent()
                ->getApplication()
                ->getServiceManager()
                ->get(\Manager\Model\ChatcampaignTable::class);
        $request = $this->getRequest();
        $data = (array) $request->getPost();
        $this->ChatcampaignTable->deleteData($data['chat_campaigns_id']);

        $this->getChatcampaignAction();
    }

}
