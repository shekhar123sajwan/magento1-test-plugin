<?php

class Leza_Celebrities_Block_Adminhtml_List_Product extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct() {
        $this->_blockGroup = 'celebrities';
        $this->_controller = 'adminhtml_list_product';
        $this->_headerText = Mage::helper('celebrities')->__('Wagon Product');
        parent::__construct();

	$this->_removeButton('add');

    }

}
