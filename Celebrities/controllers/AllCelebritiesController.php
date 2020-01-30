<?php

class Leza_Celebrities_AllCelebritiesController extends Mage_Core_Controller_Front_Action {

    public function IndexAction()
    { 
      $this->loadLayout();
      $this->getLayout()->getBlock("head")->setTitle($this->__("Rider List"));
      $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home"),
                "title" => $this->__("Home"),
                "link"  => Mage::getBaseUrl()
           ));

      $breadcrumbs->addCrumb("celebrities", array(
                "label" => $this->__("Rider"),
                "title" => $this->__("Rider")
           ));


       $this->getLayout()->getBlock('root')->setTemplate('page/1column.phtml');

       $myBlock = $this->getLayout()->createBlock('celebrities/CelebritiesList', 'Celebrities List', array('template' => 'celebrities/front/celebrities.phtml'));
       $myBlock->setData('page_heading', "RIDER'S WAGON");

       $this->getLayout()->getBlock('content')->append($myBlock);


      $this->renderLayout();
    }

    public function indexTrainerAction()
    {
      $this->loadLayout();
      $this->getLayout()->getBlock("head")->setTitle($this->__("Trainer List"));
      $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home"),
                "title" => $this->__("Home"),
                "link"  => Mage::getBaseUrl()
           ));

      $breadcrumbs->addCrumb("celebrities", array(
                "label" => $this->__("Trainer"),
                "title" => $this->__("Trainer")
           ));


       $this->getLayout()->getBlock('root')->setTemplate('page/1column.phtml');

       $myBlock = $this->getLayout()->createBlock('celebrities/TrainerList', 'Trainer List', array('template' => 'celebrities/front/celebrities.phtml'));
       $myBlock->setData('page_heading', "TRAINER'S WAGON");

       $this->getLayout()->getBlock('content')->append($myBlock);


      $this->renderLayout();
    }

}  
