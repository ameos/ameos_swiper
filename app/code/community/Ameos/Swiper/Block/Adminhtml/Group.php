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

class Ameos_Swiper_Block_Adminhtml_Group extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * @construct
     */ 
    public function __construct()
    {
        $this->_controller = 'adminhtml_group';
        $this->_blockGroup = 'ameos_swiper';
        //le texte du header qui s’affichera dans l’admin
        $this->_headerText = 'Sliders (groupe de slide)';
        //le nom du bouton pour ajouter une un contact
        $this->_addButtonLabel = 'Ajouter un slider';
        parent::__construct();
    }
}
