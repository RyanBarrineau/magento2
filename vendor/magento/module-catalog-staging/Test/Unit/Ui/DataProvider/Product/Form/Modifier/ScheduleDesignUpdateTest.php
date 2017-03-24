<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\CatalogStaging\Test\Unit\Ui\DataProvider\Product\Form\Modifier;

use Magento\CatalogStaging\Ui\DataProvider\Product\Form\Modifier\ScheduleDesignUpdate;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\ScheduleDesignUpdate as CatalogScheduleDesignUpdate;
use Magento\Framework\Stdlib\ArrayManager;

class ScheduleDesignUpdateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ScheduleDesignUpdate
     */
    protected $model;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $modifierMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $arrayMergerMock;

    protected function setUp()
    {
        $this->modifierMock = $this->getMock(
            'Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\ScheduleDesignUpdate',
            [],
            [],
            '',
            false
        );
        $this->arrayMergerMock = $this->getMock('Magento\Framework\Stdlib\ArrayManager', [], [], '', false);
        $this->model = new ScheduleDesignUpdate(
            $this->arrayMergerMock,
            $this->modifierMock
        );
    }

    public function testModifyMeta()
    {
        $containerPath = 'schedule-design-update/children/container_custom_design';
        $customDesignPath = $containerPath . '/children/custom_design';
        $customDesignTab = ['key' => 'value'];
        $meta = [];
        $valueMap = [
            [
                $containerPath . CatalogScheduleDesignUpdate::META_CONFIG_PATH,
                $meta,
                ['sortOrder' => 0],
                ArrayManager::DEFAULT_PATH_DELIMITER,
                $meta
            ],
            [
                $customDesignPath . CatalogScheduleDesignUpdate::META_CONFIG_PATH,
                $meta,
                ['label' => 'Theme'],
                ArrayManager::DEFAULT_PATH_DELIMITER,
                $meta
            ]
        ];
        $this->modifierMock->expects($this->once())->method('modifyMeta')->with($meta)->willReturn($meta);
        $this->arrayMergerMock->expects($this->exactly(2))->method('merge')->willReturnMap($valueMap);
        $this->arrayMergerMock
            ->expects($this->once())
            ->method('get')
            ->with($containerPath, $meta, null, ArrayManager::DEFAULT_PATH_DELIMITER)
            ->willReturn($customDesignTab);
        $this->arrayMergerMock
            ->expects($this->once())
            ->method('set')
            ->with(
                'design/children/schedule-design-update',
                $meta,
                $customDesignTab,
                ArrayManager::DEFAULT_PATH_DELIMITER
            )
            ->willReturn($meta);
        $this->arrayMergerMock
            ->expects($this->once())
            ->method('remove')
            ->with('schedule-design-update', $meta, ArrayManager::DEFAULT_PATH_DELIMITER)
            ->willReturn($meta);
        $this->assertEquals($meta, $this->model->modifyMeta($meta));
    }

    public function testModifyData()
    {
        $data = [];
        $this->modifierMock->expects($this->once())->method('modifyData')->with($data)->willReturn(['key' => 'value']);
        $this->assertEquals(['key' => 'value'], $this->model->modifyData($data));
    }
}
