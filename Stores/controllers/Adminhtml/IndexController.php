<?php
class Leza_Stores_Adminhtml_IndexController extends Mage_Adminhtml_Controller_Action {

    protected function _initAction() {
        $this->loadLayout()->_setActiveMenu('system/countrystores')
                ->_addBreadcrumb($this->__('Manage Country Store'), $this->__('Manage Country Store'));

        return $this;
    }

    public function indexAction() {
        $this->_title($this->__('System'))->_title($this->__('Manage Country Store'));
        $this->loadLayout();
        $this->_setActiveMenu('system/countrystores');
        $this->_addContent($this->getLayout()->createBlock('countrystores/adminhtml_list'));

        $this->renderLayout();
    }

    public function gridAction() {
        $this->loadLayout();
        $this->getResponse()->setBody(
                $this->getLayout()->createBlock('countrystores/adminhtml_list_grid')->toHtml()
        );
    }

    public function productGridAction() {
        $this->loadLayout();
	$id = $this->getRequest()->getParam('id');
	$model = Mage::getModel('countrystores/countrystores');
	$model->load($id);

        Mage::register('countrystores', $model);
        $this->getResponse()->setBody(
                $this->getLayout()->createBlock('countrystores/adminhtml_list_product_grid')->toHtml()
        );
    }

    public function newAction() {
        // We just forward the new action to a blank edit form
        $this->_forward('edit');
    }

    public function editAction() {        
        // Get id if available
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getSingleton('countrystores/countrystores');

        if ($id) {
	    $model->load($id);

            // Check if record is loaded
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('Store does not exists.'));
                $this->_redirect('*/*/');
                return;
            }
        } 

        if (!empty($data)) {
             $model->setData($data);
        }

        Mage::register('countrystores', $model);
 
	$this->loadLayout();

        $this->_addContent($this->getLayout()->createBlock('countrystores/adminhtml_list_edit'))->_addLeft($this->getLayout()->createBlock("countrystores/adminhtml_list_edit_tabs"));

        $this->renderLayout();
    }

    public function saveAction() {
        if ($postData = $this->getRequest()->getPost()) {

            $model = Mage::getSingleton('countrystores/countrystores');
//            var_dump($postData);
            $id = $this->getRequest()->getParam('id');
//            die;
            if(!$id) { 
               $postData['create_date'] = Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s');
            }

            //celebrity image save
            try {
                if ((bool) $postData['store_flag']['delete'] == 1) {
                    $postData['store_flag'] = '';
                } else {
                    unset($postData['store_flag']);
                    if (isset($_FILES)) {
                        if ($_FILES['store_flag']['name']) {
                            $path = Mage::getBaseDir('media') . DS . 'flags' . DS;
                            $uploader = new Varien_File_Uploader('store_flag');
                            $uploader->setAllowedExtensions(array('jpg', 'png', 'gif'));
                            $uploader->setAllowRenameFiles(false);
                            $uploader->setFilesDispersion(false);
                            $destFile = $path . $_FILES['store_flag']['name'];
                            $filename = $uploader->getNewFileName($destFile); 
                            $filter_name = preg_replace('/[^a-zA-Z0-9_.]/', '_', $filename); 
                            $uploader->save($path, $filter_name);

                            $postData['store_flag'] = 'flags/' . $filter_name;
                        }
                    }
                }
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } 

            $storeName = trim($postData['store_name']);
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $storeName)));

            $shipping_rate = (float) $postData['shipping_rate'];

            $postData['store_en'] = $slug.'eng';
            $postData['store_ar'] = $slug;

            $postData['shipping_rate'] = $shipping_rate;



            $model->setData($postData);

            try {

                $model->save();

                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The Store has been saved.'));
                $this->_redirect('*/*/');

                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('An error occurred while saving this Store.'));
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












 
