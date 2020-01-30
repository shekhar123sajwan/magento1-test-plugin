<?php

class Leza_Stores_Model_Observer { 
   
   public function setStoreByIP($observer)
   {   

        $userIp =  trim($_SERVER['REMOTE_ADDR']);

        $setCountry = false;

        $apiUrl = "http://api.ipstack.com/".$userIp."?access_key=e8cf4054d524ee80238f033f8a72ed95";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $data = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch); 
        if($httpcode == 200) {

            $data = json_decode($data, true); 

            $countryCode = $data['country_code'];

            $stores = Mage::getModel('countrystores/countrystores')->getCollection();

            $stores->addFieldToFilter('store_country', $countryCode);

            $stores->addFieldToFilter('store_status', 1);

            $cookie = Mage::getSingleton('core/cookie');
             
            $storeCountryCookie = $cookie->get('store_country');

            $expiryTime = time() + 24*60*60;

            list($value, $expiry) = explode("|", $storeCountryCookie);

            $cookieExpire = false;

            if(time() > $expiry) {
            	$cookieExpire = true; 
            }

            if($stores->getData() && empty($storeCountry) && $cookieExpire ) {
                   
                $storeCurrency = $stores->getData()[0]['store_currency'];

            	$cookie->set('currency', $storeCurrency, 86400,'/store');

            	$cookie->set('store_country', "$storeCurrency|$expiryTime", $expiryTime,'/store');
 
                Mage::app()->getStore()->setCurrentCurrencyCode($storeCurrency);

            }


        } 

        return false;

       }
}
