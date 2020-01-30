<?php
class Leza_Celebrities_Block_Adminhtml_List_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs 
{
    public function __construct(){
        parent::__construct();   
        $this->setId('form_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle('Wagon');  
     }

    
	protected function _beforeToHtml()
	{
		$this->addTab("form_section", array(
			"label" => Mage::helper("celebrities")->__("Wagon Information"),
			"title" => Mage::helper("celebrities")->__("Wagon Information"),
			"content" => $this->getLayout()->createBlock("celebrities/adminhtml_list_edit_tab_form")->toHtml(),
		));
		$this->addTab("product_section", array(
			"label" => Mage::helper("celebrities")->__("Wagon Products"),
			"title" => Mage::helper("celebrities")->__("Wagon Products"),
			"content" => $this->getLayout()->createBlock("celebrities/adminhtml_list_product")->toHtml(),
		));
		return parent::_beforeToHtml();
	}

}

?>
