<?php



class Leza_Celebrities_Adminhtml_CelebritiesController extends Mage_Adminhtml_Controller_Action {

    protected function _initAction() {
        $this->loadLayout()->_setActiveMenu('system/celebrities')
                ->_addBreadcrumb($this->__('Manage Wagon'), $this->__('Manage Wagon'));

        return $this;
    }

    public function indexAction() {
        $this->_title($this->__('System'))->_title($this->__('Manage Wagon'));
        $this->loadLayout();
        $this->_setActiveMenu('system/celebrity');
        $this->_addContent($this->getLayout()->createBlock('celebrities/adminhtml_list'));

        $this->renderLayout();
    }

    public function gridAction() {
        $this->loadLayout();
        $this->getResponse()->setBody(
                $this->getLayout()->createBlock('celebrities/adminhtml_list_grid')->toHtml()
        );
    }

    public function productGridAction() {
        $this->loadLayout();
	$id = $this->getRequest()->getParam('id');
	$model = Mage::getModel('celebrities/celebrities');
	$model->load($id);

        Mage::register('celebrity', $model);
        $this->getResponse()->setBody(
                $this->getLayout()->createBlock('celebrities/adminhtml_list_product_grid')->toHtml()
        );
    }

    public function newAction() {
        // We just forward the new action to a blank edit form
        $this->_forward('edit');
    }

    public function editAction() {

        
        // Get id if available
        $id = $this->getRequest()->getParam('id');


        $model = Mage::getModel('celebrities/celebrities')->getCollection();
   
 
        if ($id) {

             $storeId = ($this->getRequest()->getParam('store')) ? $this->getRequest()->getParam('store') : 1;


            $writeConnection = Mage::getSingleton('core/resource')->getConnection('core_write'); 

            $query = "select * from celebrity_data where store_id= '".$storeId."' and celebrity_id = '".$id."' ";
            //$query = "Delete from {$tableName} where celebrity_id = ". (int) $celebrity_id;
            $record_exist = $writeConnection->fetchOne($query);

            if($record_exist) {

             $model->getSelect()->joinLeft(
                    ['celebrity_data' => 'celebrity_data'],
                    'main_table.celebrity_id = celebrity_data.celebrity_id',
                    ['*']
                ) 
                ->where('celebrity_data.store_id="'.$storeId.'" AND main_table.celebrity_id="'.$id.'" ')
             ;    

            }else {

                 $model->addFieldToFilter('celebrity_id', array('eq' => $id));

            }      
          

           if($model->getData()) {
                foreach ($model->getData()[0] as $key => $value) {
                    # code...
                    $celebData[$key] = $value;
                }
           }
            // print_r($celebData);
            // die; 
            // Load record
            // $model->load($id);

            // Check if record is loaded
            if (!$celebData['celebrity_id']) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('Celebrity does not exists.'));
                $this->_redirect('*/*/');

                return;
            }
        } 

        $this->_title($celebData['celebrity_id'] ? $celebData['celebrity_name'] : $this->__('New Celebrity'));

       // $data = Mage::getSingleton('adminhtml/session')->getCelebrityData(true);

        // if (!empty($data)) {
        //     $model->setData($data);
        // }

        Mage::register('celebrity', $celebData);
 
	    $this->loadLayout();


        $store_view = $this->getLayout()->createBlock('adminhtml/store_switcher');  

        $this->getLayout()->getBlock('left')->append($store_view);
        $this->getLayout()->getBlock('head')->addJs('celebrities/custom.js');

        $this->_addContent($this->getLayout()->createBlock('celebrities/adminhtml_list_edit'))->_addLeft($this->getLayout()->createBlock("celebrities/adminhtml_list_edit_tabs"));

        $this->renderLayout();
    }

    public function saveAction() {
        if ($postData = $this->getRequest()->getPost()) {

            $model = Mage::getSingleton('celebrities/celebrities');

            $productModel = Mage::getSingleton('celebrities/products');

            
            $id = $this->getRequest()->getParam('id');
            
            $storeId = 1;

            if($this->getRequest()->getParam('store_id')) {
                $storeId = $this->getRequest()->getParam('store_id');
            }

            if(!$id) { 
               $postData['create_date'] = Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s');
            }

            //celebrity image save
            try {
                if ((bool) $postData['celebrity_image']['delete'] == 1) {
                    $postData['celebrity_image'] = '';
                } else {
                    unset($postData['celebrity_image']);
                    if (isset($_FILES)) {
                        if ($_FILES['celebrity_image']['name']) {
                            $path = Mage::getBaseDir('media') . DS . 'celebrities' . DS . 'image' . DS;
                            $uploader = new Varien_File_Uploader('celebrity_image');
                            $uploader->setAllowedExtensions(array('jpg', 'png', 'gif'));
                            $uploader->setAllowRenameFiles(false);
                            $uploader->setFilesDispersion(false);
                            $destFile = $path . $_FILES['celebrity_image']['name'];
                            $filename = $uploader->getNewFileName($destFile); 
                            $filter_name = preg_replace('/[^a-zA-Z0-9_.]/', '_', $filename); 
                            $uploader->save($path, $filter_name);

                            $postData['celebrity_image'] = 'celebrities/image/' . $filter_name;
                        }
                    }
                }
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } 

            //celebrity banner image save
            try {
                if ((bool) $postData['celebrity_banner']['delete'] == 1) {
                    $postData['celebrity_banner'] = '';
                } else {
                    unset($postData['celebrity_banner']);
                    if (isset($_FILES)) {
                        if ($_FILES['celebrity_banner']['name']) {
                            $path = Mage::getBaseDir('media') . DS . 'celebrities' . DS . 'banner_image' . DS;
                            $uploader = new Varien_File_Uploader('celebrity_banner');
                            $uploader->setAllowedExtensions(array('jpg', 'png', 'gif'));
                            $uploader->setAllowRenameFiles(false);
                            $uploader->setFilesDispersion(false);
                            $destFile = $path . $_FILES['celebrity_banner']['name'];
                            $filename = $uploader->getNewFileName($destFile); 
                            $filter_name = preg_replace('/[^a-zA-Z0-9_.]/', '_', $filename); 
                            $uploader->save($path, $filter_name);

                            $postData['celebrity_banner'] = 'celebrities/banner_image/' . $filter_name;
                        }
                    }
                }
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
           
            $celebrityName = trim($postData['celebrity_name']);
            $shortDesc = trim($postData['short_description']); 

            unset($postData['short_description']);

            //if($postData); die;
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $celebrityName)));
            
            if($postData['store_id'] <= 1)  {
               
               $postData['celebrity_slug'] = $slug; 
            }


            $model->setData($postData);

            try {

                $model->save();

        		$celebrity_id = $model->getId();

        		if($celebrity_id){

        			$checkedProducts = explode(',', $postData['checked_product_id']);

        			$resource = Mage::getSingleton('core/resource');
        			$tableName = $resource->getTableName('celebrities/products');
        			$writeConnection = $resource->getConnection('core_write');
        			$query = "Delete from {$tableName} where celebrity_id = ". (int) $celebrity_id;
        			$writeConnection->query($query);
        			// foreach($postData['id'] as $id){
        			// 	$query = "insert into {$tableName} set celebrity_id = ". (int) $celebrity_id .", product_id = ". (int) $id;
        			// 	$writeConnection->query($query);
        			// }
        			//die; 

        			foreach($checkedProducts as $id){
        				$query = "insert into {$tableName} set celebrity_id = ". (int) $celebrity_id .", product_id = ". (int) $id;
        				$writeConnection->query($query);
        			}        			
        		}

                $delteCeleb = "DELETE FROM celebrity_data WHERE celebrity_id = ".$celebrity_id." AND store_id = ".$storeId." ";

                $writeConnection->query($delteCeleb);

                $celebData = array('celebrity_id' => $celebrity_id, 
                             'celebrity_name' => $celebrityName, 
                              'short_description' => $shortDesc,   
                              'store_id' => $storeId);

                $writeConnection->insert('celebrity_data', $celebData);            

                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The celebrity has been saved.'));
                $this->_redirect('*/*/');

                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                echo $e->getMessage(); die;
                Mage::getSingleton('adminhtml/session')->addError($this->__('An error occurred while saving this celebrity.'));
            }

            Mage::getSingleton('adminhtml/session')->setCelebrityData($postData);
            $this->_redirectReferer();
        }
    }

    public function massChangeStatusAction() {
        $postData = $this->getRequest()->getPost();
        $celebrity_ids = $postData['celebrity'];

        $status = $this->getRequest()->getParam('status');

        if (!is_array($celebrity_ids)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select celebrity(s)'));
        } else {
            try {
                foreach ($celebrity_ids as $celebrity_id) {
                    $celebrity = Mage::getModel('celebrities/celebrities')->load($celebrity_id);
                    $celebrity->setData('celebrity_status', $status);
                    $celebrity->save();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                        Mage::helper('adminhtml')->__('Status is changed for selected celebrities.')
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/');
    }

    /**
     * Check currently called action by permissions for current user
     *
     * @return bool
     */
    protected function _isAllowed() {
        return Mage::getSingleton('admin/session')->isAllowed('system/celebrities');
    }

    public function assignAction() {
        if ($postData = $this->getRequest()->getPost()) {
            var_dump($postData);
            $celebrity_id = $postData['assign_celebrity'];
            $product_id = $postData['product_id'];

            if (!$celebrity_id) {
                Mage::getSingleton('adminhtml/session')->addError('Invalid Celebrity!');
                $this->_redirectReferer();
                return;
            }

            if (!$product_id) {
                Mage::getSingleton('adminhtml/session')->addError('Invalid Celebrity!');
                $this->_redirectReferer();
                return;
            }

            try {
                $products = Mage::getModel('celebrities/products');
                
                // Remove already assigned driver
                $collection = $products->getCollection()->addFieldToFilter('product_id', $product_id)->getFirstItem();
                
                if(count($collection->getData())){
                            $collection->delete();
                }

                // Assign new Celebrities
                $products->setData('celebrity_id', $celebrity_id);
                $products->setData('product_id', $product_id);
                $products->setData('create_date', Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s'));
                $products->save();

                // Load Driver
                $driver = Mage::getModel('celebrities/celebrities');
                $driver->load($celebrity_id);
                
                // Add order history
                // $order = Mage::getModel('sales/order')->load($product_id);
                // $history = $order->addStatusHistoryComment('Driver - '.$driver->getData('driver_name').' is assigned to order!', false);
                // $history->setIsCustomerNotified(false);
                // $history->setIsVisibleOnFront(false);
                // $order->save();
                
                Mage::getSingleton('adminhtml/session')->addSuccess('Celebrity has been assigned to Product.');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            $this->_redirectReferer();
        }
    }

}












 