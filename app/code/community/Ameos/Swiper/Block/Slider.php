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

class Ameos_Swiper_Block_Slider extends Mage_Core_Block_Abstract
{
    /**
     * @var int $sliderId
     */
    protected $sliderId;

    /**
     * @var int $pagination
     */
    protected $pagination = 1;

    /**
     * @var int $prevnext
     */
    protected $prevnext = 1;

    /**
     * set slider id
     * @param int $sliderId
     */
    public function setSliderId($sliderId)
    {
        $this->sliderId = $sliderId;
    }

    /**
     * set pagination
     * @param int $pagination
     */
    public function setPagination($pagination)
    {
        $this->pagination = $pagination;
    }

    /**
     * set prevnext
     * @param int $prevnext
     */
    public function setPrevnext($prevnext)
    {
        $this->prevnext = $prevnext;
    }

    /**
     * Override this method in descendants to produce html
     *
     * @return string
     */
    protected function _toHtml()
    {
        $slider = Mage::getModel('ameos_swiper/group')->load((int)$this->sliderId);
        $slides = Mage::getModel('ameos_swiper/slide')->getCollection()->addFilter('group_id', $slider->getId());
        
        $output = '
        <div class="swiper-container" id="swiper-' . $slider->getId() . '">
            <div class="swiper-wrapper">';

        foreach ($slides as $slide) {
            $output .= '<div class="swiper-slide"><img src="' . $slide->getResizedImageUrl(1200) . '" /></div>';
        }

        $output .= '
            </div>
            ' . ($this->pagination ? '<div class="swiper-pagination"></div>' : '') . '
            ' . ($this->prevnext ? '<div class="swiper-button-prev"></div><div class="swiper-button-next"></div>' : '') . '
        </div>
        <script type="text/javascript">
        jQuery(document).ready(function () {
            var swiper' . $slider->getId() . ' = new Swiper ("#swiper-' . $slider->getId() . '", {
                loop: true,
                ' . ($this->pagination ? 'pagination: ".swiper-pagination",' : '') . '
                ' . ($this->prevnext ? 'nextButton: ".swiper-button-next",' : '') . '
                ' . ($this->prevnext ? 'prevButton: ".swiper-button-prev",' : '') . '
                paginationClickable: true,
                autoplay: "3000"
            });
        });
        </script>';
        return $output;
    }
}
