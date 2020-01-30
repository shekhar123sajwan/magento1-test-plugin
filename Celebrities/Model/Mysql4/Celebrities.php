<?php
class Leza_Celebrities_Model_Mysql4_Celebrities extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("celebrities/celebrities", "celebrity_id");
    }

}