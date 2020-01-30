<?php
class Leza_Stores_Block_Countrystore extends Mage_Directory_Block_Currency
{

 public function getCountries() {

  	$countrystoresCollection = Mage::getModel('countrystores/countrystores')->getCollection();

	$countrystoresCollection->addFieldToFilter('store_status', array('eq' => 1))
         ->setOrder('sort_order', 'ASC')
		 ->getSelect();

    return $countrystoresCollection;
 }


// public function getSwitchUrl()
// {
//     return $this->getUrl('directory/currency/switch');
// }


// public function getSwitchCurrencyUrl($code)
// {
//     return Mage::helper('directory/url')->getSwitchCurrencyUrl(array('currency' => $code));
// }


public function getMediaUrl() {

	return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA);

}

// public function getCurrentCurrencyCode()
// {
//     if (is_null($this->_getData('current_currency_code'))) {
//         // do not use Mage::app()->getStore()->getCurrentCurrencyCode() because of probability
//         // to get an invalid (without base rate) currency from code saved in session
//         $this->setData('current_currency_code', Mage::app()->getStore()->getCurrentCurrency()->getCode());
//     }

//     return $this->_getData('current_currency_code');
// }


public function getCurrentCurrencyFlag($countryCollection, $current_currency_code)  { 

        $countryCollection->addFieldToFilter('store_currency', array('eq' => $current_currency_code))
		 ->getSelect(); 
         
        if($countryCollection->getData()) {

        	$currency = $countryCollection->getData();

        	return $currency[0]['store_flag'];
        } 

        return null;
}

}   