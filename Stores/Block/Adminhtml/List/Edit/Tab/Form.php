<?php
class Leza_Stores_Block_Adminhtml_List_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    { 

	$model = Mage::registry('countrystores');

        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend'    => Mage::helper('checkout')->__('Country Stores Information'),
            'class'     => 'fieldset-wide',
        ));
     
        if ($model['country_store_id']) {
            $fieldset->addField('country_store_id', 'hidden', array(
                'name' => 'country_store_id'
            ));
        }
     
        $fieldset->addField('store_name', 'text', array(
            'name'      => 'store_name',
            'label'     => 'Store Name',
            'title'     => 'Store Name',
            'required'  => true,
        ));

        $fieldset->addField('store_name_ar', 'text', array(
            'name'      => 'store_name_ar',
            'label'     => 'Store Name Arabic',
            'title'     => 'Store Name Arabic',
            'required'  => true,
        ));

        $fieldset->addField('store_flag', 'image', array(
          'name'      => 'store_flag',
          'label'     => ('Upload Flag Icon'), 
          'note' => '(*.jpg, *.png, *.gif)'
        )); 

        $fieldset->addField('shipping_rate', 'text', array(
          'name'      => 'shipping_rate',
          'label'     => ('Shipping Rate')
        )); 

        $fieldset->addField('store_status', 'select', array(
            'name'      => 'store_status',
            'label'     => 'Status',
            'title'     => 'Status',
            'required'  => true,
            'options'   => array(
                0 => $this->__('No'),
                1 => $this->__('Yes')
            )
        )); 

        /*$fieldset->addField('store_country', 'select', array(
            'name'      => 'store_country',
            'label'     => 'Country',
            'title'     => 'Country',
            'required'  => true,
            'options'   => array(
                0 => $this->__('No'),
                1 => $this->__('Yes')
            )
        )); 

        $fieldset->addField('store_currency', 'select', array(
            'name'      => 'store_currency',
            'label'     => 'Currency',
            'title'     => 'Currency',
            'required'  => true,
            'options'   => array(
                0 => $this->__('No'),
                1 => $this->__('Yes')
            )
        ));*/

        //$data = $model->getData();
 
        $data = $model;
        //print_r($data); die;

        $form->setValues($data);

        return parent::_prepareForm();
    }
}
