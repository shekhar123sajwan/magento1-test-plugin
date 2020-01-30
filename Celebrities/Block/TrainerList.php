<?php
class Leza_Celebrities_Block_TrainerList extends Mage_Core_Block_Template
{

    private $_itemPerPage = 4;
    private $_pageFrame = 100;
    private $_curPage = 1; 
    
    public function getCollection($collection = 'null') {
        if($collection != 'null'){
            $page = $this->getRequest()->getParam('p');

            if($page) $this->_curPage = $page;

            if(!empty($this->getRequest()->getParam('alpha'))) { 

            	$filters = $this->getRequest()->getParam('alpha');
            }

            if(!empty($this->getRequest()->getParam('celebrity_query')) ) { 

            	$filters = $this->getRequest()->getParam('celebrity_query');
            }

            $store_id = (Mage::app()->getStore()->getStoreId()) ? Mage::app()->getStore()->getStoreId() : 1;
            
            // if( $store_id > 1 && empty($filters) ) {

            //     $collection->addFieldToFilter('cb.store_id', array('eq' => $store_id));  

            // }else if($store_id == 1 || $store_id == 2 ) {
               
            //    $collection->addFieldToFilter('cb.store_id', array('eq' => $store_id)); 
               
            // }
            
            $collection->addFieldToFilter('cb.celebrity_name', array('like' => $filters."%"));  

            return $collection;
        }
    }
    
    // public function getPagerHtml($collection = 'null') {    

    //     $html = false; 

    //     if($collection == 'null') return;
    //     if($collection->count() > $this->_itemPerPage)
    //     {
    //         $curPage = $this->getRequest()->getParam('p');
    //         $pager = (int)($collection->count() / $this->_itemPerPage);
    //         $count = ($collection->count() % $this->_itemPerPage == 0) ? $pager : $pager + 1 ;
    //         $url = $this->getPagerUrl();
    //         $start = 1;
    //         $end = $this->_pageFrame;
            
    //         $html .= '<ol>';
    //         if(isset($curPage) && $curPage != 1){
    //             $start = $curPage - 1;                                        
    //             $end = $start + $this->_pageFrame;
    //         }else{
    //             $end = $start + $this->_pageFrame;
    //         }
    //         if($end > $count){
    //             $start = $count - ($this->_pageFrame-1);
    //         }else{
    //             $count = $end-1;
    //         }
            
    //         for($i = $start; $i<=$count; $i++)
    //         {
    //             if($i >= 1){
    //                 if($curPage){
    //                     $html .= ($curPage == $i) ? '<li class="current">'. $i .'</li>' : '<li><a href="'.$url.'celebrities/all?p='.$i.'">'. $i .'</a></li>';
    //                 }else{
    //                     $html .= ($i == 1) ? '<li class="current">'. $i .'</li>' : '<li><a href="'.$url.'celebrities/all?p='.$i.'">'. $i .'</a></li>';
    //                 }
    //             }
                
    //         }
            
    //         $html .= '</ol>';
    //     }
        
    //     return $html;
    // }


      public function getPagerUrl() {

        $base_url =   Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
     
        return $base_url;
    }
 
    public function getCelebritiesCollection() {

    	    $celebrityCollection = Mage::getModel('celebrities/celebrities')->getCollection();
 
            $store_id = (Mage::app()->getStore()->getStoreId()) ? Mage::app()->getStore()->getStoreId() : 1;

            $celebrityCollection->getSelect()->joinLeft(
                    array('cb' => 'celebrity_data'),'main_table.celebrity_id=cb.celebrity_id' 
                  )->where('main_table.celebrity_status=1 AND cb.store_id='.$store_id.' AND main_table.celebrity_type = "T" ');

             // $celebrityCollection->getSelect()->joinLeft(
             //        array('cb' => 'celebrity_data'),'main_table.celebrity_id=cb.celebrity_id' 
             //      )->where('main_table.celebrity_status=1');           

            // $celebrityCollection->addFieldToSelect('celebrity_id')
					       //      ->addFieldToSelect('celebrity_banner')
					       //      ->addFieldToSelect('celebrity_name')  
					       //      ->addFieldToSelect('celebrity_slug') 
					       //      ->addFieldToSelect('celebrity_image')  
					       //      ->setOrder('celebrity_id', 'DESC')
					       //      ->addFieldToFilter('celebrity_status', array('eq' => 1))
     						 //    ->getSelect();

            return $celebrityCollection;
            

    }

}   