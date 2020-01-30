<?php
class Leza_Celebrities_Block_Adminhtml_List_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    { 

	$model = Mage::registry('celebrity');

    //$writeConnection = Mage::getSingleton('core/resource')->getConnection('core_write'); 
         $helper = Mage::helper('celebrities');

        $selected_product_ids = $helper->getCelebrityProducts($model['celebrity_id']);

        //print_r($selected_product_ids); die;

        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend'    => Mage::helper('checkout')->__('Wagon Information'),
            'class'     => 'fieldset-wide',
        ));
     
        if ($model['celebrity_id']) {
            $fieldset->addField('celebrity_id', 'hidden', array(
                'name' => 'celebrity_id'
            ));
        }

         $fieldset->addField('store_id', 'hidden', array(  
          'name'      => 'store_id' 
        ));
   
        $fieldset->addField('checked_product_id', 'hidden', array(
            'name' => 'checked_product_id'
        ));

        $fieldset->addField('celebrity_name', 'text', array(
            'name'      => 'celebrity_name',
            'label'     => 'Wagon Name',
            'title'     => 'Wagon Name',
            'required'  => true,
        ));
        
        $fieldset->addField('short_description', 'textarea', array(
            'name'      => 'short_description',
            'label'     => 'Short Description',
            'title'     => 'Short Description',
            'required'  => false,
        ));       
        

        $fieldset->addField('celebrity_image', 'image', array(
          'name'      => 'celebrity_image',
          'label'     => ('Upload Wagon Image'), 
          'note' => '(*.jpg, *.png, *.gif)'
        )); 

        $fieldset->addField('celebrity_banner', 'image', array(
          'name'      => 'celebrity_banner',
          'label'     => ('Upload Banner'), 
          'note' => '(*.jpg, *.png, *.gif)'
        ));      

        $fieldset->addField('celebrity_type', 'select', array(
            'name'      => 'celebrity_type',
            'label'     => 'Wagon Type',
            'title'     => 'Wagon Type',
            'required'  => true,
            'options'   => array(
                'R' => $this->__('Riders'),
                'V' => $this->__('Vets'),
                'G' => $this->__('Grooms'),
                'T' => $this->__('Trainer')
            )
        ));                      
        
        $fieldset->addField('celebrity_status', 'select', array(
            'name'      => 'celebrity_status',
            'label'     => 'Wagon Status',
            'title'     => 'Wagon Status',
            'required'  => true,
            'options'   => array(
                0 => $this->__('No'),
                1 => $this->__('Yes')
            )
        )); 


        //$data = $model->getData();
 
        $data = $model;
        //print_r($data); die;

        $data['store_id'] = ($this->getRequest()->getParam('store')) ? $this->getRequest()->getParam('store') : 1;

        $data['checked_product_id'] = (count($selected_product_ids) > 0 ) ? implode(',', $selected_product_ids) : '';
        //print_r(count($selected_product_ids)); die;

       // print_r($data); die;

       // $data['store_id'] = ($this->getRequest()->getParam('store')) ? $this->getRequest()->getParam('store') : 1;

        $form->setValues($data);

        return parent::_prepareForm();
    }
}
