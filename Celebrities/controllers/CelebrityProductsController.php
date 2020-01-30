<?php

class Leza_Celebrities_CelebrityProducts extends Mage_Core_Controller_Front_Action {

    public function IndexAction()
    {

      $this->renderLayout();
    }

    public function successAction() 
    {
         $this->loadLayout();
    }

}
