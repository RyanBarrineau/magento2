<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\AdvancedRule\Model\Condition;

interface FilterTextGeneratorInterface
{
    /**
     * @param \Magento\Framework\DataObject $input
     * @return string[]
     */
    public function generateFilterText(\Magento\Framework\DataObject $input);
}
