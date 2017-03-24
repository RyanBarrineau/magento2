<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Staging\Model\Entity;

use Magento\Framework\Model\AbstractModel;

interface HydratorInterface
{
    /**
     * Hydrate model with data
     *
     * @param array $data
     * @return AbstractModel
     */
    public function hydrate(array $data);
}
