<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\CustomerCustomAttributes\Observer;

use Magento\Framework\Event\ObserverInterface;

class EnterpriseCustomerAttributeSave implements ObserverInterface
{
    /**
     * @var \Magento\CustomerCustomAttributes\Model\Sales\OrderFactory
     */
    protected $orderFactory;

    /**
     * @var \Magento\CustomerCustomAttributes\Model\Sales\QuoteFactory
     */
    protected $quoteFactory;

    /**
     * @param \Magento\CustomerCustomAttributes\Model\Sales\OrderFactory $orderFactory
     * @param \Magento\CustomerCustomAttributes\Model\Sales\QuoteFactory $quoteFactory
     */
    public function __construct(
        \Magento\CustomerCustomAttributes\Model\Sales\OrderFactory $orderFactory,
        \Magento\CustomerCustomAttributes\Model\Sales\QuoteFactory $quoteFactory
    ) {
        $this->orderFactory = $orderFactory;
        $this->quoteFactory = $quoteFactory;
    }

    /**
     * After save observer for customer attribute
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $attribute = $observer->getEvent()->getAttribute();
        if ($attribute instanceof \Magento\Customer\Model\Attribute && $attribute->isObjectNew()) {
            /** @var $quoteModel \Magento\CustomerCustomAttributes\Model\Sales\Quote */
            $quoteModel = $this->quoteFactory->create();
            $quoteModel->saveNewAttribute($attribute);
            /** @var $orderModel \Magento\CustomerCustomAttributes\Model\Sales\Order */
            $orderModel = $this->orderFactory->create();
            $orderModel->saveNewAttribute($attribute);
        }
        return $this;
    }
}
