<?php

namespace Manager\Model;

use RuntimeException;
use Agent\Model\Agent;
use Zend\Db\TableGateway\TableGatewayInterface;

class ChatdesignTable
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
    public function getChatdesignData($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['manager_id' => $id]);
        
        $row = $rowset->current();

        return $row;
    }
   
    /*
     * Save Agent data
     */
    public function saveChatdesign(Chatdesign $chatdesign,$chatdesign_data)
    {
        $update_data = [
            'manager_id' => $chatdesign->manager_id,
            'font' => $chatdesign->font,
            'background_color' => $chatdesign->background_color,
            'text_color' => $chatdesign->text_color,
            'button_text' => $chatdesign->button_text,
            'border_color' =>$chatdesign->border_color,
            'button_dimension' => $chatdesign->button_dimension,
            'button_location' => $chatdesign->button_location,
            'open_font' => $chatdesign->font,
            'open_background_color' => $chatdesign->open_background_color,
            'open_text_color' => $chatdesign->open_text_color,
            'open_border_color' =>$chatdesign->open_border_color,
            'open_desktop_dimension' => $chatdesign->open_desktop_dimension,
            'open_mobile_dimension' => $chatdesign->open_mobile_dimension,
            'open_tablet_dimension' => $chatdesign->open_tablet_dimension,
            'pro_font'          => $chatdesign->pro_font,
            'pro_background_color'  => $chatdesign->pro_background_color,
            'pro_text_color'        => $chatdesign->pro_text_color,
            'pro_border_color'      => $chatdesign->pro_border_color,
        ];
        $insert_data = [
            'manager_id' => $chatdesign->manager_id,
            'font' => $chatdesign->font,
            'background_color' => $chatdesign->background_color,
            'text_color' => $chatdesign->text_color,
            'button_text' => $chatdesign->button_text,
            'border_color' =>$chatdesign->border_color,
            'button_dimension' => $chatdesign->button_dimension,
            'button_location' => $chatdesign->button_location,
            'open_font' => $chatdesign->font,
            'open_background_color' => $chatdesign->open_background_color,
            'open_text_color' => $chatdesign->open_text_color,
            'open_border_color' =>$chatdesign->open_border_color,
            'open_desktop_dimension' => $chatdesign->open_desktop_dimension,
            'open_mobile_dimension' => $chatdesign->open_mobile_dimension,
            'open_tablet_dimension' => $chatdesign->open_tablet_dimension,
            'pro_font'          => $chatdesign->pro_font,
            'pro_background_color'  => $chatdesign->pro_background_color,
            'pro_text_color'        => $chatdesign->pro_text_color,
            'pro_border_color'      => $chatdesign->pro_border_color,
        ];
        foreach ($chatdesign_data as $chat_data) {
            if( $chat_data->manager_id == $chatdesign->manager_id) {
                $this->tableGateway->update($update_data, ['manager_id' => $chatdesign->manager_id]);
                return;
            }
            
        }
                $this->tableGateway->insert($insert_data);
                return;
            
            

    }
}
