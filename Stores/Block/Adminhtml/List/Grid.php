<?php
class Leza_Stores_Block_Adminhtml_List_Grid extends Mage_Adminhtml_Block_Widget_Grid{

    public function __construct() {
        parent::__construct();
        $this->setId('countrystores_grid');
        $this->setDefaultSort('countrystores_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    public function _prepareCollection() {
        $collection = Mage::getModel('countrystores/countrystores')->getCollection();
 
        $this->setCollection($collection);
        parent::_prepareCollection();
    }

    public function _prepareColumns() {
        $helper = Mage::helper('countrystores');

        $this->addColumn('id', array(
            'header' => $helper->__('ID'),
            'align' => 'left',
            'index' => 'country_store_id',
        ));

        $this->addColumn('store_name', array(
            'header' => $helper->__('Store Name'),
            'align' => 'left',
            'index' => 'store_name',
            'type'=>'text'
        ));

        $this->addColumn('store_name_ar', array(
            'header' => $helper->__('Store Name Arabic'),
            'align' => 'left',
            'index' => 'store_name_ar',
            'type'=>'text'
        ));
        
        $this->addColumn('store_flag', array(
            'header' => $helper->__('Country Flag'),
            'align' => 'left',
            'index' => 'store_flag', 
            'width' => '97',
            'renderer' => 'Leza_Stores_Block_Adminhtml_Template_Grid_Renderer_Image'
        ));

        /*$this->addColumn('store_country', array(
            'header' => $helper->__('Store Country'),
            'align' => 'left',
            'index' => 'store_country',
            'type' => 'options',
            'options' =>  array(
                0 => $this->__('No'),
                1 => $this->__('Yes'),
            ),
        ));

        $this->addColumn('store_currency', array(
            'header' => $helper->__('Store Currency'),
            'align' => 'left',
            'index' => 'store_currency',
            'type' => 'options',
            'options' =>  array(
                0 => $this->__('No'),
                1 => $this->__('Yes'),
            ),
        ));*/

        $this->addColumn('store_status', array(
            'header' => $helper->__('Status'),
            'align' => 'left',
            'index' => 'store_status',
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
        $helper = Mage::helper('countrystores');
        $this->setMassactionIdField('countrystores_id');
        $this->getMassactionBlock()->setFormFieldName('countrystores');
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
