<?php
namespace Magento\Store\Model\StoreResolver;

/**
 * Interceptor class for @see \Magento\Store\Model\StoreResolver
 */
class Interceptor extends \Magento\Store\Model\StoreResolver implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Store\Api\StoreRepositoryInterface $storeRepository, \Magento\Store\Api\StoreCookieManagerInterface $storeCookieManager, \Magento\Framework\App\RequestInterface $request, \Magento\Framework\Cache\FrontendInterface $cache, \Magento\Store\Model\StoreResolver\ReaderList $readerList, $runMode = 'store', $scopeCode = null)
    {
        $this->___init();
        parent::__construct($storeRepository, $storeCookieManager, $request, $cache, $readerList, $runMode, $scopeCode);
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentStoreId()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getCurrentStoreId');
        if (!$pluginInfo) {
            return parent::getCurrentStoreId();
        } else {
            return $this->___callPlugins('getCurrentStoreId', func_get_args(), $pluginInfo);
        }
    }
}
