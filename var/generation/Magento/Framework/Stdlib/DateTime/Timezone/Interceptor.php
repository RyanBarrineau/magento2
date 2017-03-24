<?php
namespace Magento\Framework\Stdlib\DateTime\Timezone;

/**
 * Interceptor class for @see \Magento\Framework\Stdlib\DateTime\Timezone
 */
class Interceptor extends \Magento\Framework\Stdlib\DateTime\Timezone implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\ScopeResolverInterface $scopeResolver, \Magento\Framework\Locale\ResolverInterface $localeResolver, \Magento\Framework\Stdlib\DateTime $dateTime, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, $scopeType, $defaultTimezonePath)
    {
        $this->___init();
        parent::__construct($scopeResolver, $localeResolver, $dateTime, $scopeConfig, $scopeType, $defaultTimezonePath);
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultTimezonePath()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getDefaultTimezonePath');
        if (!$pluginInfo) {
            return parent::getDefaultTimezonePath();
        } else {
            return $this->___callPlugins('getDefaultTimezonePath', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultTimezone()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getDefaultTimezone');
        if (!$pluginInfo) {
            return parent::getDefaultTimezone();
        } else {
            return $this->___callPlugins('getDefaultTimezone', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigTimezone($scopeType = null, $scopeCode = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getConfigTimezone');
        if (!$pluginInfo) {
            return parent::getConfigTimezone($scopeType, $scopeCode);
        } else {
            return $this->___callPlugins('getConfigTimezone', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getDateFormat($type = 3)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getDateFormat');
        if (!$pluginInfo) {
            return parent::getDateFormat($type);
        } else {
            return $this->___callPlugins('getDateFormat', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getDateFormatWithLongYear()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getDateFormatWithLongYear');
        if (!$pluginInfo) {
            return parent::getDateFormatWithLongYear();
        } else {
            return $this->___callPlugins('getDateFormatWithLongYear', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getTimeFormat($type = 3)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getTimeFormat');
        if (!$pluginInfo) {
            return parent::getTimeFormat($type);
        } else {
            return $this->___callPlugins('getTimeFormat', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getDateTimeFormat($type)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getDateTimeFormat');
        if (!$pluginInfo) {
            return parent::getDateTimeFormat($type);
        } else {
            return $this->___callPlugins('getDateTimeFormat', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function date($date = null, $locale = null, $useTimezone = true)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'date');
        if (!$pluginInfo) {
            return parent::date($date, $locale, $useTimezone);
        } else {
            return $this->___callPlugins('date', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function scopeDate($scope = null, $date = null, $includeTime = false)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'scopeDate');
        if (!$pluginInfo) {
            return parent::scopeDate($scope, $date, $includeTime);
        } else {
            return $this->___callPlugins('scopeDate', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function formatDate($date = null, $format = 3, $showTime = false)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'formatDate');
        if (!$pluginInfo) {
            return parent::formatDate($date, $format, $showTime);
        } else {
            return $this->___callPlugins('formatDate', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function scopeTimeStamp($scope = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'scopeTimeStamp');
        if (!$pluginInfo) {
            return parent::scopeTimeStamp($scope);
        } else {
            return $this->___callPlugins('scopeTimeStamp', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isScopeDateInInterval($scope, $dateFrom = null, $dateTo = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isScopeDateInInterval');
        if (!$pluginInfo) {
            return parent::isScopeDateInInterval($scope, $dateFrom, $dateTo);
        } else {
            return $this->___callPlugins('isScopeDateInInterval', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function formatDateTime($date, $dateType = 3, $timeType = 3, $locale = null, $timezone = null, $pattern = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'formatDateTime');
        if (!$pluginInfo) {
            return parent::formatDateTime($date, $dateType, $timeType, $locale, $timezone, $pattern);
        } else {
            return $this->___callPlugins('formatDateTime', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function convertConfigTimeToUtc($date, $format = 'Y-m-d H:i:s')
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'convertConfigTimeToUtc');
        if (!$pluginInfo) {
            return parent::convertConfigTimeToUtc($date, $format);
        } else {
            return $this->___callPlugins('convertConfigTimeToUtc', func_get_args(), $pluginInfo);
        }
    }
}
