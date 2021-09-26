<?php

/**
 *
 * Copyright © 2015 Zemez. All rights reserved.
 * See COPYING.txt for license details.
 *
 */

namespace Zemez\FilmSlider\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Zemez\FilmSlider\Api\Data\SliderItemInterface;

class SliderItem extends AbstractDb
{
    
    protected function _construct()
    {
        $this->_init('film_slider_item', 'slideritem_id');
    }

    protected function _afterLoad(\Magento\Framework\Model\AbstractModel $object)
    {
        $this->_retrieveLayerGeneralParamsArray($object);
        $this->_retrieveImageParams($object);
        $this->_insertImagesParamsToObject($object);
        return parent::_afterLoad($object); // TODO: Change the autogenerated stub
    }

    protected function _retrieveLayerGeneralParamsArray(\Magento\Framework\Model\AbstractModel $object)
    {
        if ($object->getId() && $object->getLayerGeneralParams()) {
            $object->setData(SliderItemInterface::LAYER_GENERAL_PARAMS_ARRAY,
                \Zend_Json::decode($object->getLayerGeneralParams()));
        }
    }

    protected function _retrieveImageParams(\Magento\Framework\Model\AbstractModel $object)
    {
        if ($object->getId() && $object->getImageParams()) {
            $object->setData(SliderItemInterface::IMAGE_PARAMS_ARRAY,
                \Zend_Json::decode($object->getImageParams()));
        }
    }

    protected function _insertImagesParamsToObject(\Magento\Framework\Model\AbstractModel $object)
    {
        if (!$object->getImageParamsArray()) {
            return $object;
        }

        $imageParamsArr = $object->getImageParamsArray();
        $arrayKeysRetrive =[SliderItemInterface::CONTENT,
                SliderItemInterface::IMAGE_PREVIEW_WIDTH,
                SliderItemInterface::IMAGE_PREVIEW_HEIGHT];

        foreach ($arrayKeysRetrive as $item) {
            if (array_key_exists($item, $imageParamsArr) && $imageParamsArr[$item]) {
                $object->setData($item, $imageParamsArr[$item]);
            }
        }
    }
}
