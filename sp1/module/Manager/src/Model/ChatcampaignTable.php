<?php

namespace Manager\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class ChatcampaignTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    /*
     * Fetch all data from database
     */
    public function fetchAll()
    {
        return $this->tableGateway->select();
    }
       
    /*
     * Save Agent data
     */
    public function saveData(Chatcampaign $chatcampaign)
    {
        $data = [
            'campaign_name'     => $chatcampaign->campaign_name,
            'url'               => $chatcampaign->url,
            'action'            => $chatcampaign->action,
            'chat_text'            => $chatcampaign->chat_text,
        ];
        //print_r($data);exit;
        $id = (int) $chatcampaign->chat_campaigns_id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }
        $this->tableGateway->update($data, ['chat_campaigns_id' => $id]);

    }
    
    public function deleteData($chat_campaigns_id){
        $this->tableGateway->delete(['chat_campaigns_id' => $chat_campaigns_id]);
    }
}
