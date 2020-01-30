<?php

class Leza_Celebrities_IndexController extends Mage_Core_Controller_Front_Action {

    public function IndexAction()
    {
      // $this->getRequest()->getParam('celebrity_slug'); 
      $this->loadLayout();
      $this->getLayout()->getBlock("head")->setTitle($this->__($this->getRequest()->getParam('celebrity_slug')));
      $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home"),
                "title" => $this->__("Home"),
                "link"  => Mage::getBaseUrl()
           ));

      $breadcrumbs->addCrumb("celebrity", array(
                "label" => $this->__("Wagon"),
                "title" => $this->__("Wagon")
           ));

      $this->renderLayout();
    }

}  
