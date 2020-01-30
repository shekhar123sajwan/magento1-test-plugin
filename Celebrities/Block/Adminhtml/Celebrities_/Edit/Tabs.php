<?php
class Leza_Celebrities_Block_Adminhtml_Celebrities_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {
 
    public function __construct() {
        parent::__construct();
        $this->setId('celebrity_tabs');
        $this->setDestElementId('edit_form'); // this should be same as the form id define above
        $this->setTitle(Mage::helper('celebrity')->__('News Information'));
    }
 
    protected function _beforeToHtml() {
        $this->addTab('form_section', array(
            'label' => Mage::helper('celebrity')->__('News Information'),
            'title' => Mage::helper('celebrity')->__('News Information'),
            'content' => $this->getLayout()->createBlock('news/adminhtml_news_edit_tab_form')->toHtml(),
        ));
 
        $this->addTab('form_section1', array(
            'label' => Mage::helper('news')->__('Content'),
            'title' => Mage::helper('news')->__('Content'),
            'content' => $this->getLayout()->createBlock('celebrity/adminhtml_celebrity_edit_tab_content')->toHtml(),
        ));
 
        return parent::_beforeToHtml();
    }
}