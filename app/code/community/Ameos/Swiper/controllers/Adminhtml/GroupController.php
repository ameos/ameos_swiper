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

class Ameos_Swiper_Adminhtml_GroupController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Check is allowed access to action
     *
     * @return bool
     */
    protected function _isAllowed()
    {
		return Mage::getSingleton('admin/session')->isAllowed('ameos_swiper');
    }

    /**
     * index action
     */ 
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * edit action
     */ 
    public function editAction()
    {
        $group = Mage::getModel('ameos_swiper/group')->load($this->getRequest()->getParam('id'));
		Mage::register('current_group', $group);
        
        $this->loadLayout();
        $this->renderLayout();
    }
    
    /**
     * new action
     */ 
    public function newAction()
    {
        $this->_forward('edit');
    }
    
    /**
     * delete action
     */
    public function deleteAction()
    {
        $group = Mage::getModel('ameos_swiper/group')->load($this->getRequest()->getParam('id'));
        $group->delete();
        
        Mage::getSingleton('adminhtml/session')->addSuccess($group->getTitle() . ' successfully deleted');
        
        $this->_redirect('*/*/');
        return;
    }

    /**
     * save action
     */
    public function saveAction()
    {
        if ($this->getRequest()->getPost()) {
            try {
                $postData = $this->getRequest()->getPost();
                
                $group = Mage::getModel('ameos_swiper/group');
                if ($this->getRequest()->getParam('id') > 0) {
                    $group->load($this->getRequest()->getParam('id'));
                }

                $group->setTitle($postData['group_title'])->save();
                
                Mage::getSingleton('adminhtml/session')->addSuccess($group->getTitle() . ' successfully saved');

                if ($this->getRequest()->getParam('back') == 'edit') {
                    $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));    
                } else {
                    $this->_redirect('*/*/');    
                }
                return;
            } catch (Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
    }

    /**
     * edit action
     */ 
    public function editslideAction()
    {
        $slide = Mage::getModel('ameos_swiper/slide')->load($this->getRequest()->getParam('id'));
        $group = Mage::getModel('ameos_swiper/group')->load($this->getRequest()->getParam('groupid'));
        $slide->setGroupId($group->getId());

        Mage::register('current_slide', $slide);
        Mage::register('current_group', $group);
        
        $this->loadLayout();
        $this->renderLayout();
    }
    
    /**
     * new action
     */ 
    public function newslideAction()
    {
        $this->_forward('editslide');
    }
    
    /**
     * new action
     */ 
    public function deleteslideAction()
    {
        $slide = Mage::getModel('ameos_swiper/slide')->load($this->getRequest()->getParam('id'));
        $slide->delete();
        
        Mage::getSingleton('adminhtml/session')->addSuccess($slide->getTitle() . ' successfully deleted');

        $this->_redirect('*/*/edit', array('id' => $slide->getGroupId()));
        return;
    }
    
    /**
     * save action
     */
    public function saveslideAction()
    {
        if ($this->getRequest()->getPost()) {
            try {
                $postData = $this->getRequest()->getPost();
                if ($this->getRequest()->getParam('id') > 0) {
                    $slide = Mage::getModel('ameos_swiper/slide')->load($this->getRequest()->getParam('id'));
                } else {
                    $slide = Mage::getModel('ameos_swiper/slide');
                }                
                
                
                // Save photo
                if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
                    try {    
                        $uploader = new Varien_File_Uploader('image');

                        $uploader->setAllowedExtensions(['jpg','jpeg','gif','png']);
                        $uploader->setAllowRenameFiles(false);
                        $uploader->setFilesDispersion(false);

                        // Set media as the upload dir
                        $mediaPath = Mage::getBaseDir('media') . DS . 'sliders' . DS . $slide->getGroupId() . DS;
                        if (!file_exists($mediaPath)) {
                            mkdir($mediaPath, 0770, true);
                        }

                        // Upload the image
                        $uploader->save($mediaPath, $_FILES['image']['name']);
                        $postData['image'] = 'sliders' . DS . $slide->getGroupId() . DS . $_FILES['image']['name'];
                        
                    } catch (Exception $e) {
                        Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                        $this->_redirect('*/*/editslide', array('id' => $this->getRequest()->getParam('id')));
                    }                            
                } else {       
                    if(isset($postData['image']['delete']) && $postData['image']['delete'] == 1) {
                        $postData['image'] = '';
                    } else {
                        unset($postData['image']);
                    }
                }
                $slide->addData($postData);
                $slide->save();
                
                Mage::getSingleton('adminhtml/session')->addSuccess('successfully saved');
                $this->_redirect('*/*/edit', array('id' => $slide->getGroupId()));
                return;
            } catch (Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/editslide', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
    }
}
