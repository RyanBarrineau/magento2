<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\AdvancedRule\Model\Condition;

interface FilterableConditionInterface
{
    /**
     * Whether this condition can be filtered using index table
     *
     * @return bool
     */
    public function isFilterable();

    /**
     * Return a list of filter groups that represent this condition
     *
     * @return FilterGroupInterface[]
     */
    public function getFilterGroups();
}
