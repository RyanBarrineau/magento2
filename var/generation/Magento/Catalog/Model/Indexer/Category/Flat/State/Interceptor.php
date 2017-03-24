<?php
namespace Magento\Catalog\Model\Indexer\Category\Flat\State;

/**
 * Interceptor class for @see \Magento\Catalog\Model\Indexer\Category\Flat\State
 */
class Interceptor extends \Magento\Catalog\Model\Indexer\Category\Flat\State implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Framework\Indexer\IndexerRegistry $indexerRegistry, $isAvailable = false)
    {
        $this->___init();
        parent::__construct($scopeConfig, $indexerRegistry, $isAvailable);
    }

    /**
     * {@inheritdoc}
     */
    public function isFlatEnabled()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isFlatEnabled');
        if (!$pluginInfo) {
            return parent::isFlatEnabled();
        } else {
            return $this->___callPlugins('isFlatEnabled', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isAvailable()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isAvailable');
        if (!$pluginInfo) {
            return parent::isAvailable();
        } else {
            return $this->___callPlugins('isAvailable', func_get_args(), $pluginInfo);
        }
    }
}
