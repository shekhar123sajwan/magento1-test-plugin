<?php
class Leza_Stores_Block_Adminhtml_List_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Init class
     */
    public function __construct()
    {  
        $this->_blockGroup = 'countrystores';
        $this->_controller = 'adminhtml_list';
     
        parent::__construct();
     
        $this->_updateButton('save', 'label', $this->__('Save Country Store'));
        
        $this->_removeButton('delete');
        $this->_removeButton('reset');
    }  
     
    /**
     * Get Header text
     *
     * @return string
     */
    public function getHeaderText()
    {  
         
        if (Mage::registry('countrystores')['country_store_id']) {
            return $this->__('Edit Country Store');
        }  
        else {
            return $this->__('New Country Store');
        }  
    }  
}
