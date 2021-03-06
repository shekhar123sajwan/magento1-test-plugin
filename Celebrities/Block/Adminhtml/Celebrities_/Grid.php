<?php

class Leza_Celebrities_Block_Adminhtml_Celebrities_Grid extends Mage_Adminhtml_Block_Widget_Grid {
 
    public function __construct() {
        parent::__construct();
        $this->setId('leza_celebrities_grid');
        $this->setDefaultSort('celebrity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }
 
    protected function _prepareCollection() {
        $collection = Mage::getModel('celebrities/celebrities')->getCollection();
        
        $this->setCollection($collection);
        parent::_prepareCollection();
    }
 
       public function _prepareColumns() {
        $helper = Mage::helper('celebrities');

        $this->addColumn('id', array(
            'header' => $helper->__('ID'),
            'align' => 'left',
            'index' => 'celebrity_id',
        ));

        $this->addColumn('celebrity_name', array(
            'header' => $helper->__('Celebrity Name'),
            'align' => 'left',
            'index' => 'celebrity_name',
            'type'=>'text'
        ));
        
        $this->addColumn('celebrity_image', array(
            'header' => $helper->__('Celebrity Image'),
            'align' => 'left',
            'index' => 'celebrity_image', 
            'width' => '97',
            'renderer' => 'Leza_Celebrities_Block_Adminhtml_Template_Grid_Renderer_Image'
        ));

        $this->addColumn('celebrity_status', array(
            'header' => $helper->__('Status'),
            'align' => 'left',
            'index' => 'celebrity_status',
            'type' => 'options',
            'options' =>  array(
                0 => $this->__('No'),
                1 => $this->__('Yes'),
            ),
        ));
        
        $this->addColumn('create_date', array(
            'header' => $helper->__('Create Date'),
            'align' => 'left',
            'type' => 'datetime',
            'index' => 'create_date',
        ));

        parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        // This is where our row data will link to
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
    
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    public function _prepareMassaction() {
        $helper = Mage::helper('celebrities');
        $this->setMassactionIdField('celebrity_id');
        $this->getMassactionBlock()->setFormFieldName('celebrity');
        //$this->getMassactionBlock()->setFormFieldName('boutiqaattv');

        $this->getMassactionBlock()->addItem('active', array(
            'label' => $helper->__('Enable'),
            'url' => $this->getUrl('*/*/massChangeStatus',array('status'=>1)),
            'confirm' => $helper->__('Are you sure?')
        ));
        $this->getMassactionBlock()->addItem('inactive', array(
            'label' =>$helper->__('Disable'),
            'url' => $this->getUrl('*/*/massChangeStatus',array('status'=>0)),
            'confirm' => $helper->__('Are you sure?')
        ));
        $statuses = array(
            0 => $this->__('Disable'),
            1 => $this->__('Enable'),
        );

        return $this;
    }
}