<?php
class Leza_Stores_Model_Mysql4_Countrystores extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("countrystores/countrystores", "country_store_id");
    }

}
