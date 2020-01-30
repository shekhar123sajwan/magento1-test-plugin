<?php
class Leza_Stores_Model_Countrystores extends Mage_Core_Model_Abstract {
    protected function _construct(){
        parent::_construct();
        $this->_init("countrystores/countrystores");
    }  

}
