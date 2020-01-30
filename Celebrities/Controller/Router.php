<?php 
class Leza_Celebrities_Controller_Router extends Mage_Core_Controller_Varien_Router_Standard
{
	/**
	 * Initialize Controller Router
	*/
	public function initControllerRouters($observer)
	{
		$front = $observer->getEvent()->getFront();	
		$front->addRouter('celebrities', $this);
	}
	
	/**
	* Validate and Match shop view and modify request
	*/
	public function match(Zend_Controller_Request_Http $request)
	{


        $_path = urldecode(trim($request->getPathInfo(),'/'));

        $_end = '';
        if (strpos($_path,$_end)){
        	$_link_params = explode('/',str_replace($_end,'/',$_path),-1);
        }else{
        	$_link_params = explode('/',$_path.'/',-1);
        }
        $_count_params = count($_link_params);
        

        if(isset($_link_params[0]) && $_link_params[0] == "rider" && ( !isset($_link_params[1]) || empty($_link_params[1]) ) )  {
        	 
               Mage::app()->getFrontController()->getResponse()
                ->setRedirect(Mage::getUrl('install'))
                ->sendResponse();

                exit;


        } 

        if(isset($_link_params[0]) && $_link_params[0] == "rider" && isset($_link_params[1]) && $_link_params[1] !== 'all') {

          $url_slug = trim($_link_params[1]); 
          

    		  $request->setModuleName('celebrities') 
                      ->setControllerName('Index')
                      ->setActionName('index');
              $request->setAlias(
                    Mage_Core_Model_Url_Rewrite::REWRITE_REQUEST_PATH_ALIAS,
                    $url_slug
              )
              ->setParam('celebrity_slug', $url_slug); 

              return  true;

        }
         
         //print_r($request); die;
        if( ( isset($_link_params[0]) && $_link_params[0] == "rider" )
           && ( isset($_link_params[1]) && $_link_params[1] == 'all' ) ) {

          $url_slug = trim($_link_params[1]);  

          $request->setModuleName('celebrities') 
                      ->setControllerName('AllCelebrities')
                      ->setActionName('index');
                      $request->setAlias(
                            Mage_Core_Model_Url_Rewrite::REWRITE_REQUEST_PATH_ALIAS,
                            $url_slug
                      )
              ->setParam('celebrities', 'all')
              ->setParam('celeb_page', 'rider/all'); 

              return  true;

        }        

         //print_r($request); die;
        if( ( isset($_link_params[0]) && $_link_params[0] == "trainer" )
           && ( isset($_link_params[1]) && $_link_params[1] == 'all' ) ) { 

          $url_slug = trim($_link_params[1]); 

          $request->setModuleName('celebrities') 
                      ->setControllerName('AllCelebrities')
                      ->setActionName('indexTrainer');
                      $request->setAlias(
                            Mage_Core_Model_Url_Rewrite::REWRITE_REQUEST_PATH_ALIAS,
                            $url_slug
                      )
              ->setParam('trainer', 'all')
              ->setParam('celeb_page', 'trainer/all'); 

              return  true;

        }  

        if( ( isset($_link_params[0]) && $_link_params[0] == "trainer" )
           && ( isset($_link_params[1]) && $_link_params[1] !== 'all' ) ) { 

          $url_slug = trim($_link_params[1]); 

          //echo "<pre>";print_r($request);

          $request->setModuleName('celebrities') 
                      ->setControllerName('Index')
                      ->setActionName('index');
                      $request->setAlias(
                            Mage_Core_Model_Url_Rewrite::REWRITE_REQUEST_PATH_ALIAS,
                            $url_slug
                      ) 
                  ->setParam('celebrity_slug', $url_slug);  

              return  true;

        }    
        return false;
        
	}
}