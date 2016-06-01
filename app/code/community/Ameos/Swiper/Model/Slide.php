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

class Ameos_Swiper_Model_Slide extends Mage_Core_Model_Abstract
{
    /**
     * magento construct
     */ 
    public function _construct()
    {
        parent::_construct();
        $this->_init('ameos_swiper/slide');
    }
    
    /**
     * return image url
     * @return string
     */
    public function getImageUrl()
    {
        return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . $this->getImage();
    }
    
    /**
     * return image url
     * @return string
     */
    public function getImagePath()
    {
        return Mage::getBaseDir('media') . DS . $this->getImage();
    }
    
    /**
     * return image url
     * @param int $width
     * @param int $height
     * @return string
     */
    public function getResizedImageUrl($width, $height = null)
    {
        $imagePath = $this->getImagePath();
        $imageFilename = basename($imagePath);

        $directoryName = 'w' . $width;
        if (!is_null($height)) {
            $directoryName .= 'h' . $height;
        }
        
        $imageResizedDirectory = Mage::getBaseDir('media') 
            . DS . 'sliders' 
            . DS . 'resized' 
            . DS . $this->getGroupId()
            . DS . $directoryName
            . DS;
            
        $imageResized = $imageResizedDirectory . $imageFilename;
        if (!file_exists($imageResized) && file_exists($imagePath)) {
            if (!file_exists($imageResizedDirectory)) {
                mkdir($imageResizedDirectory, 0770, true);
            }
        
            $imageObj = new Varien_Image($imagePath);
            $imageObj->constrainOnly(false);
            $imageObj->keepAspectRatio(true);
            $imageObj->keepFrame(false);
            $imageObj->resize($width, $height);
            $imageObj->save($imageResized);
        }
        
        return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . 'sliders' 
            . DS . 'resized' 
            . DS . $this->getGroupId()
            . DS . $directoryName
            . DS . $imageFilename;
    }
    
    
}
/*
 * // actual path of image

 
// path of the resized image to be saved
// here, the resized image is saved in media/resized folder
$imageResized = Mage::getBaseDir('media').DS."myimage".DS."resized".DS.$post->getThumbnail();
 
// resize image only if the image file exists and the resized image file doesn't exist
// the image is resized proportionally with the width/height 135px
if (!file_exists($imageResized)&&file_exists($_imageUrl)) :
	$imageObj = new Varien_Image($_imageUrl);
	$imageObj->constrainOnly(TRUE);
	$imageObj->keepAspectRatio(TRUE);
	$imageObj->keepFrame(FALSE);
	$imageObj->resize(135, 135);
	$imageObj->save($imageResized);
endif;*/
