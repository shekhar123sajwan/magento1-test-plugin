<?php
class Leza_Celebrities_Model_Products extends Mage_Core_Model_Abstract {
    protected function _construct(){
        parent::_construct();
        $this->_init("celebrities/products");
    }
}