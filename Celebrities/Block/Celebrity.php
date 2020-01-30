<?php
class Leza_Celebrities_Block_Celebrity extends Mage_Catalog_Block_Product_List
{

	private $_celebrity = [];

     public function getLoadedProductCollection()
     {
     	
          $slug_name = $this->getRequest()->getParam('celebrity_slug');

          $store_id = (Mage::app()->getStore()->getStoreId()) ? Mage::app()->getStore()->getStoreId() : 1;

     	if($slug_name) {

     		$celebrityCollection = Mage::getModel('celebrities/celebrities')->getCollection();
 
            // $celebrityCollection->addFieldToSelect('celebrity_id')
					       //      ->addFieldToSelect('celebrity_banner')
					       //      ->addFieldToSelect('celebrity_name') 
     						 //    ->addFieldToFilter('celebrity_slug', trim($slug_name))
     						 //    ->getSelect();

                 $celebrityCollection->getSelect()->joinLeft(
                    array('cb' => 'celebrity_data'),'main_table.celebrity_id=cb.celebrity_id' 
                  )->where('main_table.celebrity_status=1 AND main_table.celebrity_slug = "'.$slug_name.'" AND cb.store_id='.$store_id.'');


     		$celebrity_id = $celebrityCollection->getFirstItem()->getCelebrityId();

     		$this->_celebrity['banner'] = $celebrityCollection->getFirstItem()->getCelebrityBanner();

     		$this->_celebrity['name'] = $celebrityCollection->getFirstItem()->getCelebrityName();

     	    if($celebrity_id) {

     		  $celebProductsCollection = Mage::getModel('celebrities/products')->getCollection();

     		  $cpTable =  $celebProductsCollection->getMainTable(); 

     		  $productCollection = Mage::getModel('catalog/product')->getCollection();
     		  $productCollection->addAttributeToSelect('*')->addAttributeToFilter('status', ['eq' => 1]);

     		  $productCollection->getSelect()->join(
										    array(
										      'cp'=> $cpTable
										    ),
										    'cp.product_id = e.entity_id'
										   )
     		                               ->where('cp.celebrity_id=?',$celebrity_id);

               return $productCollection;

     	    }

           return null;
     	} 

     }

     public function getCelebrityData() {
          
          return $this->_celebrity;

     }

}