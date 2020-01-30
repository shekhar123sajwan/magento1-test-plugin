<?php
class Leza_Celebrities_Block_Adminhtml_List_Product_Grid extends Mage_Adminhtml_Block_Widget_Grid{

    public function __construct() {
        parent::__construct();
        $this->setId('leza_celebrities_product_grid');
        $this->setDefaultSort('celebrity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        //return parent::__construct();
    }
 
    public function _prepareCollection() {
        $collection = Mage::getModel('catalog/product')->getCollection()
	->addAttributeToSelect('*')
	->addAttributeToFilter('status', array('eq' => Mage_Catalog_Model_Product_Status::STATUS_ENABLED));
	$collection->joinField('qty',
                'cataloginventory/stock_item',
                'qty',
                'product_id=entity_id',
                '{{table}}.stock_id=1',
                'left');
	$collection->setOrder('entity_id', 'DESC');
        
        $this->setCollection($collection);
        parent::_prepareCollection();
    }

    public function _prepareColumns() {
        $helper = Mage::helper('celebrities');

	$model = Mage::registry('celebrity');

//echo $model->getData('celebrity_id');

	$selected_product_ids = $helper->getCelebrityProducts($model['celebrity_id']);
//var_dump($selected_product_ids);
	$this->addColumn('product_id', array(
	    'header_css_class' => 'a-center',
	    'header' => $helper->__('Select'),
	    'index' => 'entity_id',
	    'type' => 'checkbox',
	    'field_name' => 'id[]',
	    'align' => 'center',
		'values' => $selected_product_ids
	));


	$this->addColumn('entity_id', array(
            'header' => $helper->__('ID'),
            'align' => 'left',
            'index' => 'entity_id',
            'type'=>'text'
        ));

        $this->addColumn('name', array(
            'header' => $helper->__('Name'),
            'align' => 'left',
            'index' => 'name',
            'type'=>'text'
        ));

        $this->addColumn('sku', array(
            'header' => $helper->__('SKU'),
            'align' => 'left',
            'index' => 'sku',
            'type'=>'text'
        ));

	$this->addColumn('qty',
		array(
		    'header'=> Mage::helper('catalog')->__('Qty'),
		    'width' => '100px',
		    'type'  => 'number',
		    'index' => 'qty'
	));

	$this->addColumn('visibility',
            array(
                'header'=> Mage::helper('catalog')->__('Visibility'),
                'width' => '70px',
                'index' => 'visibility',
                'type'  => 'options',
                'options' => Mage::getModel('catalog/product_visibility')->getOptionArray(),
        ));
        parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
//var_dump($row->getData());
        // This is where our row data will link to
        return ;
    }
    
    public function getGridUrl()
    {
        return $this->getUrl('*/*/productGrid', array('_current'=>true));
    }

}
