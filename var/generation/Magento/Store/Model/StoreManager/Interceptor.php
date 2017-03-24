<?php
namespace Magento\Store\Model\StoreManager;

/**
 * Interceptor class for @see \Magento\Store\Model\StoreManager
 */
class Interceptor extends \Magento\Store\Model\StoreManager implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Store\Api\StoreRepositoryInterface $storeRepository, \Magento\Store\Api\GroupRepositoryInterface $groupRepository, \Magento\Store\Api\WebsiteRepositoryInterface $websiteRepository, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Store\Api\StoreResolverInterface $storeResolver, \Magento\Framework\Cache\FrontendInterface $cache, $isSingleStoreAllowed = true)
    {
        $this->___init();
        parent::__construct($storeRepository, $groupRepository, $websiteRepository, $scopeConfig, $storeResolver, $cache, $isSingleStoreAllowed);
    }

    /**
     * {@inheritdoc}
     */
    public function setCurrentStore($store)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setCurrentStore');
        if (!$pluginInfo) {
            return parent::setCurrentStore($store);
        } else {
            return $this->___callPlugins('setCurrentStore', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setIsSingleStoreModeAllowed($value)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setIsSingleStoreModeAllowed');
        if (!$pluginInfo) {
            return parent::setIsSingleStoreModeAllowed($value);
        } else {
            return $this->___callPlugins('setIsSingleStoreModeAllowed', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function hasSingleStore()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'hasSingleStore');
        if (!$pluginInfo) {
            return parent::hasSingleStore();
        } else {
            return $this->___callPlugins('hasSingleStore', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isSingleStoreMode()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isSingleStoreMode');
        if (!$pluginInfo) {
            return parent::isSingleStoreMode();
        } else {
            return $this->___callPlugins('isSingleStoreMode', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getStore($storeId = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getStore');
        if (!$pluginInfo) {
            return parent::getStore($storeId);
        } else {
            return $this->___callPlugins('getStore', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getStores($withDefault = false, $codeKey = false)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getStores');
        if (!$pluginInfo) {
            return parent::getStores($withDefault, $codeKey);
        } else {
            return $this->___callPlugins('getStores', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getWebsite($websiteId = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getWebsite');
        if (!$pluginInfo) {
            return parent::getWebsite($websiteId);
        } else {
            return $this->___callPlugins('getWebsite', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getWebsites($withDefault = false, $codeKey = false)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getWebsites');
        if (!$pluginInfo) {
            return parent::getWebsites($withDefault, $codeKey);
        } else {
            return $this->___callPlugins('getWebsites', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function reinitStores()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'reinitStores');
        if (!$pluginInfo) {
            return parent::reinitStores();
        } else {
            return $this->___callPlugins('reinitStores', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultStoreView()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getDefaultStoreView');
        if (!$pluginInfo) {
            return parent::getDefaultStoreView();
        } else {
            return $this->___callPlugins('getDefaultStoreView', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getGroup($groupId = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getGroup');
        if (!$pluginInfo) {
            return parent::getGroup($groupId);
        } else {
            return $this->___callPlugins('getGroup', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getGroups($withDefault = false)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getGroups');
        if (!$pluginInfo) {
            return parent::getGroups($withDefault);
        } else {
            return $this->___callPlugins('getGroups', func_get_args(), $pluginInfo);
        }
    }
}
