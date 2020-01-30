<?php

class Leza_Celebrities_Block_Adminhtml_List extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct() {
        $this->_blockGroup = 'celebrities';
        $this->_controller = 'adminhtml_list';
        $this->_headerText = Mage::helper('celebrities')->__('Manage Wagon');

        parent::__construct();

    }

}
