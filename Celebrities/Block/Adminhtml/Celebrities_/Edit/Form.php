<?php
class Leza_Celebrities_Block_Adminhtml_Celebrities_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
  
     
    /**
     * Setup form fields for inserts/updates
     *
     * return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {  

        if (Mage::registry('celebrity')) {
            $data = Mage::registry('celebrity')->getData();
        } else {
            $data = array();
        }

     
        $form = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method'    => 'post',
            'enctype'   => 'multipart/form-data'
        ));
     
        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend'    => Mage::helper('checkout')->__('Celebrity Information'),
            'class'     => 'fieldset-wide',
        ));
     
        if ($model->getId()) {
            $fieldset->addField('celebrity_id', 'hidden', array(
                'name' => 'celebrity_id'
            ));
        }
     
        $fieldset->addField('celebrity_name', 'text', array(
            'name'      => 'celebrity_name',
            'label'     => 'Celebrity Name',
            'title'     => 'Celebrity Name',
            'required'  => true,
        ));
        
        // $fieldset->addField('driver_email', 'text', array(
        //     'name'      => 'driver_email',
        //     'label'     => 'Driver Email',
        //     'title'     => 'Driver Email',
        //     'required'  => true,
        // ));
        
        // $password_required = true;
        // if ($model->getId()) {
        //     $password_required = false;
        // }
        
        // $fieldset->addField('driver_password', 'text', array(
        //     'name'      => 'driver_password',
        //     'label'     => 'Driver Password',
        //     'title'     => 'Driver Password',
        //     'required'  => $password_required,
        // ));
        
        $fieldset->addField('short_description', 'textarea', array(
            'name'      => 'short_description',
            'label'     => 'Short Description',
            'title'     => 'Short Description',
            'required'  => false,
        ));       
        

        $fieldset->addField('celebrity_image', 'image', array(
          'name'      => 'celebrity_image',
          'label'     => ('Upload Celebrity Image'), 
          'note' => '(*.jpg, *.png, *.gif)'
        )); 

        $fieldset->addField('celebrity_banner', 'image', array(
          'name'      => 'celebrity_banner',
          'label'     => ('Upload Banner'), 
          'note' => '(*.jpg, *.png, *.gif)'
        ));      

        $fieldset->addField('celebrity_type', 'select', array(
            'name'      => 'celebrity_type',
            'label'     => 'Celebrity Type',
            'title'     => 'Celebrity Type',
            'required'  => true,
            'options'   => array(
                'R' => $this->__('Riders'),
                'V' => $this->__('Vets'),
                'G' => $this->__('Grooms')
            )
        ));                      
        
        $fieldset->addField('celebrity_status', 'select', array(
            'name'      => 'celebrity_status',
            'label'     => 'Celebrity Status',
            'title'     => 'Celebrity Status',
            'required'  => true,
            'options'   => array(
                0 => $this->__('No'),
                1 => $this->__('Yes')
            )
        ));
     
        $data = $model->getData();
 
        $form->setValues($data);
        $form->setUseContainer(true);
        $this->setForm($form);
     
        return parent::_prepareForm();
    }  
}