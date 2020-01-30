<?php
class Leza_Celebrities_Block_Adminhtml_List_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Init class
     */
    public function __construct()
    {  
        $this->_blockGroup = 'celebrities';
        $this->_controller = 'adminhtml_list';
     
        parent::__construct();
     
        $this->_updateButton('save', 'label', $this->__('Save Wagon'));
        
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
         
        if (Mage::registry('celebrity')['celebrity_id']) {
            return $this->__('Edit Wagon');
        }  
        else {
            return $this->__('New Wagon');
        }  
    }  
}