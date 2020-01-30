<?php

class Leza_Stores_Block_Adminhtml_List extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct() {
        $this->_blockGroup = 'countrystores';
        $this->_controller = 'adminhtml_list';
        $this->_headerText = Mage::helper('countrystores')->__('Manage Country Stores');
        parent::__construct();

    }

}
