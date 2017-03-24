<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Support\Model\Report\Group\Events;

use Magento\Framework\App\Area;
use Magento\Framework\Event\ConfigInterface;

/**
 * Core global events section
 */
class CoreGlobalEventsSection extends AbstractEventsSection
{
    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return (string)__('Core Global Events');
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return ConfigInterface::TYPE_CORE;
    }

    /**
     * {@inheritdoc}
     */
    public function getAreaCode()
    {
        return Area::AREA_GLOBAL;
    }
}
