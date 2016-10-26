<?php

namespace Manager\Model;

use DomainException;

//use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


class Chatcampaign
{
    public $chat_campaigns_id;
    public $campaign_name;
    public $url;
    public $action;
    public $chat_text;
    

    public function exchangeArray(array $data)
    {
        $this->chat_campaigns_id         = !empty($data['chat_campaigns_id']) ? $data['chat_campaigns_id'] : null;
        $this->campaign_name  = !empty($data['campaign_name']) ? $data['campaign_name'] : null;
        $this->url  = !empty($data['url']) ? $data['url'] : null;
        $this->action  = !empty($data['action']) ? $data['action'] : Yes;
        $this->chat_text  = !empty($data['chat_text']) ? $data['chat_text'] : null;
        
    }
    
    // Add the following method:
    public function getArrayCopy()
    {
        return [
            'chat_campaigns_id'     => $this->chat_campaigns_id,
            'campaign_name'     => $this->campaign_name,
            'url'               => $this->url,
            'action'            => $this->action,
            'chat_text'            => $this->chat_text,
           
        ];
    }
    
   
}
