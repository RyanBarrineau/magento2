<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\CatalogInventoryStaging\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\CatalogInventory\Ui\DataProvider\Product\Form\Modifier\AdvancedInventory as InventoryModifier;

class AdvancedInventory extends AbstractModifier
{
    /**
     * @var InventoryModifier
     */
    private $inventoryModifier;

    /**
     * @param InventoryModifier $inventoryModifier
     */
    public function __construct(InventoryModifier $inventoryModifier)
    {
        $this->inventoryModifier = $inventoryModifier;
    }

    /**
     * {@inheritDoc}
     */
    public function modifyData(array $data)
    {
        return $this->inventoryModifier->modifyData($data);
    }

    /**
     * {@inheritDoc}
     */
    public function modifyMeta(array $meta)
    {
        $modifiedMeta = $this->inventoryModifier->modifyMeta($meta);
        unset($modifiedMeta[self::DEFAULT_GENERAL_PANEL]['children']['quantity_and_stock_status_qty']);
        $modifiedMeta[self::DEFAULT_GENERAL_PANEL]['children']
        ['quantity_and_stock_status']['arguments']['data']['config']['disabled'] = true;
        return $modifiedMeta;
    }
}
