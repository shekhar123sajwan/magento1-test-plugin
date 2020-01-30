<?php
class Leza_Celebrities_Helper_Data extends Mage_Core_Helper_Abstract
{

	public function getCelebrityProducts($celebrity_id){

		$productModel = Mage::getModel('celebrities/products');
		$productModel = $productModel->getCollection()->addFieldToFilter('celebrity_id', $celebrity_id);

		$product_ids = array();
		if($productModel->getSize()){
			$collection = $productModel->getData();
			foreach($collection as $data){
				$product_ids[] = $data['product_id'];
			}
		}
		
		return $product_ids;
	}
}
