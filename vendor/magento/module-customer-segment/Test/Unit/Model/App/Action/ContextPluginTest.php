<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\CustomerSegment\Test\Unit\Model\App\Action;

/**
 * Class ContextPluginTest
 */
class ContextPluginTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Magento\CustomerSegment\Model\App\Action\ContextPlugin
     */
    protected $plugin;

    /**
     * @var \Magento\Customer\Model\Session|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $customerSessionMock;

    /**
     * @var \Magento\Framework\App\Http\Context $httpContext|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $httpContextMock;

    /**
     * @var \Magento\CustomerSegment\Model\Customer|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $customerSegmentMock;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $storeManagerMock;

    /**
     * @var \Magento\Store\Model\Website|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $websiteMock;

    /**
     * @var \Closure
     */
    protected $closureMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $subjectMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $requestMock;

    /**
     * Set up
     */
    protected function setUp()
    {
        $this->customerSessionMock = $this->getMock(
            'Magento\Customer\Model\Session',
            ['getCustomerId', '__wakeup'],
            [],
            '',
            false
        );
        $this->httpContextMock = $this->getMock('Magento\Framework\App\Http\Context', [], [], '', false);
        $this->customerSegmentMock = $this->getMock(
            'Magento\CustomerSegment\Model\Customer',
            ['getCustomerId', '__wakeup', 'getCustomerSegmentIdsForWebsite'],
            [],
            '',
            false
        );
        $this->storeManagerMock = $this->getMockForAbstractClass(
            'Magento\Store\Model\StoreManagerInterface',
            [],
            '',
            false
        );
        $this->closureMock = function () {
            return 'ExpectedValue';
        };
        $this->subjectMock = $this->getMock('Magento\Framework\App\Action\Action', [], [], '', false);
        $this->requestMock = $this->getMock('Magento\Framework\App\RequestInterface');
        $this->websiteMock = $this->getMock(
            'Magento\Store\Model\Website',
            ['__wakeup', 'getId'],
            [],
            '',
            false
        );

        $this->plugin = new \Magento\CustomerSegment\Model\App\Action\ContextPlugin(
            $this->customerSessionMock,
            $this->httpContextMock,
            $this->customerSegmentMock,
            $this->storeManagerMock
        );
    }

    /**
     * Test aroundDispatch
     */
    public function testAroundDispatch()
    {
        $customerId = 1;
        $customerSegmentIds = [1, 2, 3];
        $websiteId  = 1;

        $this->customerSessionMock->expects($this->exactly(2))
            ->method('getCustomerId')
            ->will($this->returnValue($customerId));

        $this->storeManagerMock->expects($this->once())
            ->method('getWebsite')
            ->will($this->returnValue($this->websiteMock));

        $this->websiteMock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue($websiteId));

        $this->customerSegmentMock->expects($this->once())
            ->method('getCustomerSegmentIdsForWebsite')
            ->with($this->equalTo($customerId), $this->equalTo($websiteId))
            ->will($this->returnValue($customerSegmentIds));

        $this->httpContextMock->expects($this->once())
            ->method('setValue')
            ->with(
                $this->equalTo(\Magento\CustomerSegment\Helper\Data::CONTEXT_SEGMENT),
                $this->equalTo($customerSegmentIds)
            );

        $this->assertEquals(
            'ExpectedValue',
            $this->plugin->aroundDispatch($this->subjectMock, $this->closureMock, $this->requestMock)
        );
    }
}