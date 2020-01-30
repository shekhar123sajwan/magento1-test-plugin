<?php
class Leza_Celebrities_Block_Adminhtml_Template_Grid_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    { 
    	$path = Mage::getBaseUrl('media');
    	$img =  $row->getData('celebrity_image');  
        //$val = Mage::helper('catalog/image')->init($row, $path.'/Pattern_1x.png', 'null')->resize(97);
        $out = "<img src=". $path . $img ." width='90px'/>";
        return $out;
    }
}