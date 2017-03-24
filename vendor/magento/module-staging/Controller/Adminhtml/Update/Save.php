<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Staging\Controller\Adminhtml\Update;

use Magento\Framework\Controller\ResultInterface;

class Save extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Magento_Staging::admin';

    /**
     * @var \Magento\Staging\Api\UpdateRepositoryInterface
     */
    protected $updateRepository;

    /**
     * @var \Magento\Staging\Model\UpdateFactory
     */
    protected $updateFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Staging\Api\UpdateRepositoryInterface $updateRepository
     * @param \Magento\Staging\Model\UpdateFactory $updateFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Staging\Api\UpdateRepositoryInterface $updateRepository,
        \Magento\Staging\Model\UpdateFactory $updateFactory
    ) {
        $this->updateRepository = $updateRepository;
        $this->updateFactory = $updateFactory;
        parent::__construct($context);
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magento_Staging::staging');
    }

    /**
     * @return ResultInterface
     * @throws \Exception
     */
    public function execute()
    {
        try {
            $updateData = $this->getRequest()->getParam('general');
            if (isset($updateData['id']) && !empty($updateData['id'])) {
                $update = $this->updateRepository->get($updateData['id']);
            } else {
                $update = $this->updateFactory->create();
                $update->setIsCampaign(true);
            }

            $dataStart = strtotime($updateData['start_time']);
            $dataEnd = strtotime($updateData['end_time']);
            $updateStart = strtotime($update->getStartTime());
            $updateEnd = strtotime($update->getEndTime());
            if ($dataStart != $updateStart || $dataEnd != $updateEnd) {
                $updateData['old_id'] = $updateData['id'];
                unset($updateData['id']);
                unset($updateData['rollback_id']);
            }
            /** @var \Magento\Staging\Model\Update $update */
            $update->setData($updateData);
            $this->updateRepository->save($update);
            $this->messageManager->addSuccess(sprintf('You saved the "%s" campaign.', $update->getName()));
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());

            if (isset($update) && $update->getId()) {
                return $this->resultRedirectFactory->create()->setPath('*/*/edit', ['id' => $update->getId()]);
            }

            return $this->resultRedirectFactory->create()->setPath('*/*/edit');
        }

        return $this->resultRedirectFactory->create()->setPath('*/*/');
    }
}
