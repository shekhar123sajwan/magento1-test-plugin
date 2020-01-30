<?php
class Leza_Celebrities_Block_Adminhtml_Celebrities_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Init class
     */
    public function __construct()
    {  
        $this->_objectId = 'id';
        $this->_blockGroup = 'celebrities';
        $this->_controller = 'adminhtml_celebrities';
        $this->_mode = 'edit';
     
        parent::__construct();
     
        $this->_updateButton('save', 'label', $this->__('Save Celebrity'));
        
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
        if (Mage::registry('celebrity')->getId()) {
            return $this->__('Edit Celebrity');
        }  
        else {
            return $this->__('New Celebrity');
        }  
    }  
}