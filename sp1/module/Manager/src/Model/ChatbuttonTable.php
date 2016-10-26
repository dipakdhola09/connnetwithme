<?php

namespace Manager\Model;

use RuntimeException;
use Agent\Model\Agent;
use Zend\Db\TableGateway\TableGatewayInterface;

class ChatbuttonTable
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
     * Get user data from id
     */
    public function getChatbuttonData($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['manager_id' => $id]);
        
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }
   
    /*
     * Save Agent data
     */
    public function saveChatbutton(Chatbutton $chatbutton,$chatbutton_data)
    {
        $data = [
            //'manager_id' => $chatbutton->manager_id,
            'font' => $chatbutton->font,
            'background_color' => $chatbutton->background_color,
            'text_color' => $chatbutton->text_color,
            'button_text' => $chatbutton->button_text,
            'border_color' =>$chatbutton->border_color,
            'button_dimension' => $chatbutton->button_dimension,
            'button_location' => $chatbutton->button_location,
        ];
        $data1 = [
            'manager_id' => $chatbutton->manager_id,
            'font' => $chatbutton->font,
            'background_color' => $chatbutton->background_color,
            'text_color' => $chatbutton->text_color,
            'button_text' => $chatbutton->button_text,
            'border_color' =>$chatbutton->border_color,
            'button_dimension' => $chatbutton->button_dimension,
            'button_location' => $chatbutton->button_location,
        ];
        foreach ($chatbutton_data as $chat_data) {
            if( $chat_data->manager_id == $chatbutton->manager_id) {
                $this->tableGateway->update($data, ['manager_id' => $chatbutton->manager_id]);
                return;
            }
            
        }
                $this->tableGateway->insert($data1);
                return;
            
            

    }
}
