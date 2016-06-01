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

class Ameos_Swiper_Block_Adminhtml_Group_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    /**
     * construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('group_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('ameos_swiper')->__('Sliders'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label'   => Mage::helper('ameos_swiper')->__('Slider'),
            'alt'     => Mage::helper('ameos_swiper')->__('Slider'),
            'content' => $this->getLayout()->createBlock('ameos_swiper/adminhtml_group_edit_tab_form')->toHtml(),
        ));

        $group = Mage::registry('current_group');
        if ($group->getId() > 0) {
            $this->addTab('slide_section', array(
                'label'   => Mage::helper('ameos_swiper')->__('Slides'),
                'alt'     => Mage::helper('ameos_swiper')->__('Slides'),
                'content' => $this->getLayout()->createBlock('ameos_swiper/adminhtml_slide')->toHtml(),
            ));            
        }

        return parent::_beforeToHtml();
    }

}
