<?php
class Leza_Celebrities_Block_Slider extends Mage_Core_Block_Template
{
    public function getCelebrities() {

    	    $celebrityCollection = Mage::getModel('celebrities/celebrities')->getCollection();

    	    $store_id = Mage::app()->getStore()->getStoreId() ? Mage::app()->getStore()->getStoreId() : 1;

			$celebrityCollection->getSelect()->joinLeft(
                    array('cb' => 'celebrity_data'),'main_table.celebrity_id=cb.celebrity_id' 
                  )->where('main_table.celebrity_status=1 AND main_table.celebrity_type = "R" AND cb.store_id='.$store_id.'')
			     ->limit(10)
	            ; 	    

            return $celebrityCollection;
            

    }

    public function getTrainers() {

    	    $celebrityCollection = Mage::getModel('celebrities/celebrities')->getCollection();


    	    $store_id = Mage::app()->getStore()->getStoreId() ? Mage::app()->getStore()->getStoreId() : 1;

			$celebrityCollection->getSelect()->joinLeft(
                    array('cb' => 'celebrity_data'),'main_table.celebrity_id=cb.celebrity_id' 
                  )->where('main_table.celebrity_status=1 AND main_table.celebrity_type = "T"  AND cb.store_id='.$store_id.'')
			     ->limit(10)
	            ; 	    

            return $celebrityCollection;
    }    

}   
