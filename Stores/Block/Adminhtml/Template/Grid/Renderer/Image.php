<?php
class Leza_Stores_Block_Adminhtml_Template_Grid_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    { 
    	$path = Mage::getBaseUrl('media');
    	$img =  $row->getData('store_flag');  
        $out = "<img src=". $path . $img ." width='90px'/>";
        return $out;
    }
}
