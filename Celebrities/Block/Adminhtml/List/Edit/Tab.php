<?php
class Leza_Celebrities_Block_Adminhtml_Celebrities_Edit_Tab extends Mage_Adminhtml_Block_Widget_Form {
 
    protected function _prepareForm() {
 
        if (Mage::registry('celebrity')) {
            $data = Mage::registry('celebrity')->getData();
        } else {
            $data = array();
        }
 
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('celebrity', array('legend' => Mage::helper('celebrity')->__('news information')));
 
        $fieldset->addField('title', 'text', array(
            'label' => Mage::helper('news')->__('News Title'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'title',
        ));
 
        $fieldset->addField('tag', 'text', array(
            'label' => Mage::helper('news')->__('Tag'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'tag',
        ));
 
        $form->setValues($data);
 
        return parent::_prepareForm();
    }
}