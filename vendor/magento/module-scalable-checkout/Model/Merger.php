<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\ScalableCheckout\Model;

class Merger implements \Magento\Framework\MessageQueue\MergerInterface
{
    /**
     * {@inheritdoc}
     */
    public function merge(array $messageList)
    {
        return $messageList;
    }
}
