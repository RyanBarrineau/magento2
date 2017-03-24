<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Staging\Model\Entity\Builder;

use Magento\Framework\App\ObjectManager;
use Magento\Staging\Model\Entity\BuilderInterface;

/**
 * Class DefaultBuilder
 * @codeCoverageIgnore
 */
class DefaultBuilder implements BuilderInterface
{
    /**
     * Default building strategy
     *
     * @param object $prototype
     * @return object
     */
    public function build($prototype)
    {
        return clone $prototype;
    }
}
