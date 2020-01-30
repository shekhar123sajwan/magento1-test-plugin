<?php
class Leza_Stores_Block_Adminhtml_List_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs 
{
    public function __construct(){
        parent::__construct();   
        $this->setId('form_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle('Country Store');  
     }

    
	protected function _beforeToHtml()
	{
		$this->addTab("form_section", array(
			"label" => Mage::helper("countrystores")->__("Country Store Information"),
			"title" => Mage::helper("countrystores")->__("Country Store Information"),
			"content" => $this->getLayout()->createBlock("countrystores/adminhtml_list_edit_tab_form")->toHtml(),
		));
		return parent::_beforeToHtml();
	}

}

?>
