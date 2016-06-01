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

class Ameos_Swiper_Block_Adminhtml_Group_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * definition du formulaire
     */ 
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('group_form', array('legend' => Mage::helper('ameos_swiper')->__('Item information')));
        $fieldset->addField('title', 'text', array(
            'label'    => Mage::helper('ameos_swiper')->__('Titre'),
            'class'    => 'required-entry',
            'required' => true,
            'name'     => 'group_title',
        ));

        if (Mage::registry('current_group')) {
            $form->setValues(Mage::registry('current_group')->getData());
        }
        return parent::_prepareForm();
    }
}
