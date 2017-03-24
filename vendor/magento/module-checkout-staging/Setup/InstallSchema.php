<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\CheckoutStaging\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    const PREVIEW_QUOTA_TABLE = 'quote_preview';

    const ID_FIELD_NAME = 'quote_id';

    /**
     * {@inheritdoc}
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $table = $setup->startSetup()
            ->getConnection()
            ->newTable($setup->getTable(self::PREVIEW_QUOTA_TABLE))
            ->addColumn(
                self::ID_FIELD_NAME,
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false],
                'Preview Quota Id'
            )->addForeignKey(
                $setup->getFkName(
                    $setup->getTable(self::PREVIEW_QUOTA_TABLE),
                    self::ID_FIELD_NAME,
                    $setup->getTable('quote'),
                    'entity_id'
                ),
                self::ID_FIELD_NAME,
                $setup->getTable('quote'),
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )->setComment('Preview quotas list');

        $setup->getConnection()->createTable($table);

        $setup->endSetup();
    }
}
