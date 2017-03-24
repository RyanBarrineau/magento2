<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\CatalogInventoryStaging\Test\Unit\Ui\DataProvider\Product\Form\Modifier;

class AdvancedInventoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Magento\CatalogInventoryStaging\Ui\DataProvider\Product\Form\Modifier\AdvancedInventory
     */
    private $model;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $inventoryModifierMock;

    protected function setUp()
    {
        $this->inventoryModifierMock = $this->getMock(
            'Magento\CatalogInventory\Ui\DataProvider\Product\Form\Modifier\AdvancedInventory',
            ['modifyData', 'modifyMeta'],
            [],
            '',
            false
        );
        $this->model = new \Magento\CatalogInventoryStaging\Ui\DataProvider\Product\Form\Modifier\AdvancedInventory(
            $this->inventoryModifierMock
        );
    }

    public function testModifyData()
    {
        $data = ['key' => 'value'];
        $this->inventoryModifierMock->expects($this->once())->method('modifyData')->with($data)->willReturn($data);
        $this->assertEquals($data, $this->model->modifyData($data));
    }

    public function testModifyMeta()
    {
        $meta = [
            'product-details' => [
                'children' => [
                    'quantity_and_stock_status_qty' => [
                        'in_stock' => true,
                        'qty' => 100
                    ],
                    'quantity_and_stock_status' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'disabled' => false
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $modifiedMeta = [
            'product-details' => [
                'children' => [
                    'quantity_and_stock_status' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'disabled' => true
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $this->inventoryModifierMock->expects($this->once())->method('modifyMeta')->with($meta)->willReturn($meta);
        $this->assertEquals($modifiedMeta, $this->model->modifyMeta($meta));
    }
}
