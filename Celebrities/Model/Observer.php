<?php

class Leza_Celebrities_Model_Observer {
 

    public $store_country = array('kuwait' => 710, 'kuwaiteng' => 710, 'saudi_arabia' => 713, 'saudi_arabiaeng' => 713, 'qatar' => 712, 'qatareng' => 712, 'bahrain' => 708, 'bahraineng' => 708, 'oman' => 711, 'omaneng' => 711, 'united_arab_emirates' => 714, 'united_arab_emirateseng' => 714, 'international' => 709, 'internationaleng' => 709);

    public $store_currency_country =  [ "KWD" => "kuwaiteng",
                                        "KWD" => "kuwait",
                                        "SAR" => "saudi_arabiaeng",
                                        "SAR" => "saudi_arabia",
                                        "QAR" => "qatareng",
                                        "QAR" => "qatar",
                                        "BHD" => "bahraineng",
                                        "BHD" => "bahrain",
                                        "OMR" => "omaneng",
                                        "OMR" => "oman",
                                        "AED" => "united_arab_emirateseng",
                                        "AED" => "united_arab_emirates",
                                        "USD" => "internationaleng",
                                        "USD" => "international"
                                      ];

    public $store_codes_country    =  [ "kuwaiteng" => "KW",
                                        "kuwait" => "KW",
                                        "saudi_arabiaeng" => "SA",
                                        "saudi_arabia" => "SA",
                                        "qatareng" =>"QA",
                                        "qatar" => "QA",
                                        "bahraineng" => "BH",
                                        "bahrain" => "BH",
                                        "omaneng" => "OM",
                                        "oman" => "OM",
                                        "united_arab_emirateseng" => "AE",
                                        "united_arab_emirates" => "AE",
                                        "internationaleng" => "USD",
                                        "international" => "USD"
                                      ];

   public function saveItemAvailObserve($observer)
   {  

   	    $controllerName = $observer->getControllerAction()->getRequest()->getControllerName();

   	    if($controllerName !== 'cart') {
   	    	return false;
   	    }
         
        $currentStoreCurrency = Mage::app()->getStore()->getCurrentCurrencyCode(); 

        $currentStoreCountry = $this->store_currency_country[$currentStoreCurrency];

		$quote = Mage::getSingleton('checkout/session')->getQuote();
		$cartHelper = Mage::helper('checkout/cart');

		$cartItems = $quote->getAllVisibleItems();
		foreach ($cartItems as $item) {

		    $productId = $item->getProductId();    
            $product = Mage::getModel('catalog/product')->load($productId);
            $productAvailInStoresIds =  explode(',', $product->getData('shipping_store')); 

            $itemAvail = false;
     
            foreach ($productAvailInStoresIds as  $shippingStore) { 

              if( ($this->store_country[$currentStoreCountry] == 710 ) || ($shippingStore == $this->store_country[$currentStoreCountry]) ) {
                     
                     $itemAvail = true;

                }                    
            }  

            if(!$itemAvail) {
                $quote->removeItem($item->getId());
                $quote->save();  
                $cartHelper->getCart()->removeItem($item->getId())->save();
            }

		}
   }
}
