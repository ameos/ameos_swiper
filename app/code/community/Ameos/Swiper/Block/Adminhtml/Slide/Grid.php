<?php

/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 */

class Ameos_Swiper_Block_Adminhtml_Slide_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * @construct
     */ 
    public function __construct()
    {
        parent::__construct();
        $this->setId('slideGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }
    
    /**
     * prepare collection
     */
    protected function _prepareCollection()
    {
        $group = Mage::registry('current_group');
        
        $collection = Mage::getModel('ameos_swiper/slide')->getCollection();
        $collection->addFilter('group_id', $group->getId());
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    
    /**
     * prepare columns
     */
    protected function _prepareColumns()
    {
        $this->addColumn('id', [
            'header' => 'ID',
            'align'  => 'right',
            'width'  => '50px',
            'index'  => 'id',
        ]);
        $this->addColumn('title', [
            'header' => 'Titre',
            'align'  => 'left',
            'index'  => 'title',
        ]);
        $this->addColumn('image', [
            'header'   => 'Image',
            'align'    => 'left',
            'index'    => 'image',
            'renderer' => 'Ameos_Swiper_Block_Adminhtml_Renderer_Image',
        ]);
        return parent::_prepareColumns();
    }
    
    /**
     * return row url
     * @param Ameos_Swiper_Model_Group $row
     * @return string
     */ 
    public function getRowUrl($row)
    {
        $group = Mage::registry('current_group');
        
        return $this->getUrl('*/*/editSlide', [
            'id'      => $row->getId(),
            'groupid' => $group->getId()
        ]);
    }
}
