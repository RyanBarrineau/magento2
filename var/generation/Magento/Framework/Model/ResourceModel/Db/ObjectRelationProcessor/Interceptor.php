<?php
namespace Magento\Framework\Model\ResourceModel\Db\ObjectRelationProcessor;

/**
 * Interceptor class for @see \Magento\Framework\Model\ResourceModel\Db\ObjectRelationProcessor
 */
class Interceptor extends \Magento\Framework\Model\ResourceModel\Db\ObjectRelationProcessor implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct()
    {
        $this->___init();
    }

    /**
     * {@inheritdoc}
     */
    public function delete(\Magento\Framework\Model\ResourceModel\Db\TransactionManagerInterface $transactionManager, \Magento\Framework\DB\Adapter\AdapterInterface $connection, $table, $condition, array $involvedData)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'delete');
        if (!$pluginInfo) {
            return parent::delete($transactionManager, $connection, $table, $condition, $involvedData);
        } else {
            return $this->___callPlugins('delete', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function validateDataIntegrity($table, array $involvedData)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'validateDataIntegrity');
        if (!$pluginInfo) {
            return parent::validateDataIntegrity($table, $involvedData);
        } else {
            return $this->___callPlugins('validateDataIntegrity', func_get_args(), $pluginInfo);
        }
    }
}
