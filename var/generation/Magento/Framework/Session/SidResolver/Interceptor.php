<?php
namespace Magento\Framework\Session\SidResolver;

/**
 * Interceptor class for @see \Magento\Framework\Session\SidResolver
 */
class Interceptor extends \Magento\Framework\Session\SidResolver implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Framework\UrlInterface $urlBuilder, \Magento\Framework\App\RequestInterface $request, $scopeType, array $sidNameMap = array())
    {
        $this->___init();
        parent::__construct($scopeConfig, $urlBuilder, $request, $scopeType, $sidNameMap);
    }

    /**
     * {@inheritdoc}
     */
    public function getSid(\Magento\Framework\Session\SessionManagerInterface $session)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSid');
        if (!$pluginInfo) {
            return parent::getSid($session);
        } else {
            return $this->___callPlugins('getSid', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSessionIdQueryParam(\Magento\Framework\Session\SessionManagerInterface $session)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSessionIdQueryParam');
        if (!$pluginInfo) {
            return parent::getSessionIdQueryParam($session);
        } else {
            return $this->___callPlugins('getSessionIdQueryParam', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setUseSessionVar($var)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setUseSessionVar');
        if (!$pluginInfo) {
            return parent::setUseSessionVar($var);
        } else {
            return $this->___callPlugins('setUseSessionVar', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getUseSessionVar()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getUseSessionVar');
        if (!$pluginInfo) {
            return parent::getUseSessionVar();
        } else {
            return $this->___callPlugins('getUseSessionVar', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setUseSessionInUrl($flag = true)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setUseSessionInUrl');
        if (!$pluginInfo) {
            return parent::setUseSessionInUrl($flag);
        } else {
            return $this->___callPlugins('setUseSessionInUrl', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getUseSessionInUrl()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getUseSessionInUrl');
        if (!$pluginInfo) {
            return parent::getUseSessionInUrl();
        } else {
            return $this->___callPlugins('getUseSessionInUrl', func_get_args(), $pluginInfo);
        }
    }
}
