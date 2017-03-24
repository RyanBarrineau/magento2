<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Staging\Test\Unit\Model\Entity\Update\Action\Save;

use Magento\Staging\Model\Entity\Update\Action\Save\SaveAction;
use Magento\Staging\Model\EntityStaging;
use Magento\Staging\Model\Entity\Update\Action\ActionInterface;
use Magento\Staging\Controller\Adminhtml\Entity\Update\Service;

class SaveActionTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Magento\Staging\Model\VersionManager|\PHPUnit_Framework_MockObject_MockObject */
    protected $versionManager;

    /** @var \Magento\Staging\Model\Entity\HydratorInterface|\PHPUnit_Framework_MockObject_MockObject */
    protected $hydrator;

    /** @var \Magento\Staging\Model\Update|\PHPUnit_Framework_MockObject_MockObject */
    protected $update;

    /** @var EntityStaging|\PHPUnit_Framework_MockObject_MockObject */
    private $entityStaging;

    /** @var Service|\PHPUnit_Framework_MockObject_MockObject */
    private $updateService;

    public function setUp()
    {
        $this->updateService = $this->getMockBuilder(Service::class)
            ->disableOriginalCOnstructor()
            ->getMock();
        $this->versionManager = $this->getMockBuilder('Magento\Staging\Model\VersionManager')
            ->disableOriginalConstructor()
            ->getMock();
        $this->hydrator = $this->getMockBuilder('Magento\Staging\Model\Entity\HydratorInterface')
            ->getMockForAbstractClass();
        $this->update = $this->getMockBuilder('Magento\Staging\Model\Update')
            ->disableOriginalConstructor()
            ->getMock();
        $this->entityStaging = $this->getMockBuilder(EntityStaging::class)->disableOriginalConstructor()->getMock();

        $this->saveAction = new SaveAction(
            $this->updateService,
            $this->versionManager,
            $this->hydrator,
            $this->entityStaging
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage stagingData is required parameter.
     */
    public function testExecuteWithInvalidParams()
    {
        $this->saveAction->execute([]);
    }

    public function testExecute()
    {
        $params = [
            'stagingData' => [],
            'entityData' => [],
        ];
        $versionId = 32;
        $this->updateService->expects($this->once())
            ->method('createUpdate')
            ->with([])
            ->willReturn($this->update);
        $this->versionManager->expects($this->any())
            ->method('getVersion')
            ->willReturn($this->update);
        $this->update->expects($this->any())
            ->method('getId')
            ->willReturn($versionId);
        $this->versionManager->expects($this->once())
            ->method('setCurrentVersionId')
            ->with($versionId);
        $entity = new \stdClass();
        $this->hydrator->expects($this->once())
            ->method('hydrate')
            ->with([])
            ->willReturn($entity);
        $this->entityStaging->expects($this->once())
            ->method('schedule')
            ->with($entity, $versionId, []);
        $this->assertTrue($this->saveAction->execute($params));
    }

    public function testExecuteEditEntityInCampaign()
    {
        $updateId = 12;
        $stagingData = [];
        $params = [
            'stagingData' => $stagingData,
            'entityData' => [],
        ];

        $this->versionManager->expects($this->any())
            ->method('getVersion')
            ->willReturn($this->update);
        $this->updateService->expects($this->once())
            ->method('createUpdate')
            ->with([])
            ->willReturn($this->update);
        //Check that campaign never edited
        $this->updateService->expects($this->never())->method('editUpdate');
        $this->update->expects($this->any())
            ->method('getId')
            ->willReturn($updateId);
        $this->versionManager->expects($this->once())
            ->method('setCurrentVersionId')
            ->with($updateId);
        $entity = new \stdClass();
        $this->hydrator->expects($this->once())
            ->method('hydrate')
            ->with([])
            ->willReturn($entity);
        $this->entityStaging->expects($this->once())
            ->method('schedule')
            ->with($entity, $updateId, []);
        $this->saveAction->execute($params);
    }

    public function testExecuteWithEditUpdate()
    {
        $updateId = 12;
        $newUpdateId = 13;
        $stagingData = [
            'update_id' => $updateId,
        ];
        $params = [
            'stagingData' => $stagingData,
            'entityData' => [],
        ];

        $this->versionManager->expects($this->any())
            ->method('getVersion')
            ->willReturn($this->update);
        $this->updateService->expects($this->once())
            ->method('editUpdate')
            ->with($stagingData)
            ->willReturn($this->update);
        $this->update->expects($this->at(0))
            ->method('getId')
            ->willReturn($updateId);
        $this->update->expects($this->at(1))
            ->method('getId')
            ->willReturn($newUpdateId);
        $this->update->expects($this->at(2))
            ->method('getId')
            ->willReturn($newUpdateId);
        $this->versionManager->expects($this->once())
            ->method('setCurrentVersionId')
            ->with($newUpdateId);
        $entity = new \stdClass();
        $this->hydrator->expects($this->once())
            ->method('hydrate')
            ->with([])
            ->willReturn($entity);
        $this->entityStaging->expects($this->once())
            ->method('schedule')
            ->with($entity, $newUpdateId, []);
        $this->assertTrue($this->saveAction->execute($params));
    }

    public function testExecuteRemovesPreviousUpdateAndCreatesNewOneIfUpdateDatesWereChanged()
    {
        $stagingData = [
            'update_id' => 1,
        ];
        $params = [
            'stagingData' => $stagingData,
            'entityData' => [],
        ];
        $arguments['origin_in'] = $stagingData['update_id'];
        $this->update->expects($this->any())->method('getId')->willReturn($stagingData['update_id']);

        $newUpdateId = 2;
        $newUpdate = $this->getMock(\Magento\Staging\Model\Update::class, [], [], '', false);
        $newUpdate->expects($this->any())->method('getId')->willReturn($newUpdateId);
        $this->versionManager->expects($this->once())->method('setCurrentVersionId')->with($newUpdateId);
        $this->versionManager->expects($this->any())->method('getVersion')->willReturn($newUpdate);
        $this->updateService->expects($this->once())
            ->method('editUpdate')
            ->with($stagingData)
            ->willReturn($newUpdate);

        $entity = new \stdClass();
        $this->hydrator->expects($this->once())->method('hydrate')->with($params['entityData'])->willReturn($entity);
        $this->entityStaging->expects($this->once())->method('schedule')->with($entity, $newUpdateId, $arguments);
        $this->assertTrue($this->saveAction->execute($params));
    }
}
