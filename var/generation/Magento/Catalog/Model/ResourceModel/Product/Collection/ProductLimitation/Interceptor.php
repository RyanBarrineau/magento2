<?php
namespace Magento\Catalog\Model\ResourceModel\Product\Collection\ProductLimitation;

/**
 * Interceptor class for @see \Magento\Catalog\Model\ResourceModel\Product\Collection\ProductLimitation
 */
class Interceptor extends \Magento\Catalog\Model\ResourceModel\Product\Collection\ProductLimitation implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct()
    {
        $this->___init();
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'offsetExists');
        if (!$pluginInfo) {
            return parent::offsetExists($offset);
        } else {
            return $this->___callPlugins('offsetExists', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'offsetGet');
        if (!$pluginInfo) {
            return parent::offsetGet($offset);
        } else {
            return $this->___callPlugins('offsetGet', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'offsetSet');
        if (!$pluginInfo) {
            return parent::offsetSet($offset, $value);
        } else {
            return $this->___callPlugins('offsetSet', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'offsetUnset');
        if (!$pluginInfo) {
            return parent::offsetUnset($offset);
        } else {
            return $this->___callPlugins('offsetUnset', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getStoreId()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getStoreId');
        if (!$pluginInfo) {
            return parent::getStoreId();
        } else {
            return $this->___callPlugins('getStoreId', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getCategoryId()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getCategoryId');
        if (!$pluginInfo) {
            return parent::getCategoryId();
        } else {
            return $this->___callPlugins('getCategoryId', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getCategoryIsAnchor()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getCategoryIsAnchor');
        if (!$pluginInfo) {
            return parent::getCategoryIsAnchor();
        } else {
            return $this->___callPlugins('getCategoryIsAnchor', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getVisibility()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getVisibility');
        if (!$pluginInfo) {
            return parent::getVisibility();
        } else {
            return $this->___callPlugins('getVisibility', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getWebsiteIds()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getWebsiteIds');
        if (!$pluginInfo) {
            return parent::getWebsiteIds();
        } else {
            return $this->___callPlugins('getWebsiteIds', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getStoreTable()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getStoreTable');
        if (!$pluginInfo) {
            return parent::getStoreTable();
        } else {
            return $this->___callPlugins('getStoreTable', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isUsingPriceIndex()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isUsingPriceIndex');
        if (!$pluginInfo) {
            return parent::isUsingPriceIndex();
        } else {
            return $this->___callPlugins('isUsingPriceIndex', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setUsePriceIndex($value)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setUsePriceIndex');
        if (!$pluginInfo) {
            return parent::setUsePriceIndex($value);
        } else {
            return $this->___callPlugins('setUsePriceIndex', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomerGroupId()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getCustomerGroupId');
        if (!$pluginInfo) {
            return parent::getCustomerGroupId();
        } else {
            return $this->___callPlugins('getCustomerGroupId', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getWebsiteId()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getWebsiteId');
        if (!$pluginInfo) {
            return parent::getWebsiteId();
        } else {
            return $this->___callPlugins('getWebsiteId', func_get_args(), $pluginInfo);
        }
    }
}
