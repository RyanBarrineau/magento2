<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Staging\Model\Entity\Update\Action\Save;

use Magento\Staging\Controller\Adminhtml\Entity\Update\Service as UpdateService;
use Magento\Staging\Model\Entity\HydratorInterface;
use Magento\Staging\Model\EntityStaging;
use Magento\Staging\Model\Entity\Update\Action\ActionInterface;
use Magento\Staging\Model\VersionManager;

class SaveAction implements ActionInterface
{
    /**
     * @var UpdateService
     */
    private $updateService;

    /**
     * @var VersionManager
     */
    private $versionManager;

    /**
     * @var HydratorInterface
     */
    private $entityHydrator;

    /**
     * @var EntityStaging
     */
    private $entityStaging;

    /**
     * SaveAction constructor.
     * @param UpdateService $updateService
     * @param VersionManager $versionManager
     * @param EntityStaging $entityStaging
     * @param HydratorInterface $entityHydrator
     */
    public function __construct(
        UpdateService $updateService,
        VersionManager $versionManager,
        HydratorInterface $entityHydrator,
        EntityStaging $entityStaging
    ) {
        $this->updateService = $updateService;
        $this->versionManager = $versionManager;
        $this->entityHydrator = $entityHydrator;
        $this->entityStaging = $entityStaging;
    }

    /**
     * Save action
     * @param array $params
     * @return bool
     */
    public function execute(array $params)
    {
        $this->validateParams($params);
        $stagingData = $params['stagingData'];
        $arguments = [];

        if (!isset($stagingData['update_id']) || empty($stagingData['update_id'])) {
            $update = $this->updateService->createUpdate($stagingData);
        } else {
            $update = $this->updateService->editUpdate($stagingData);
            if ($update->getId() != $stagingData['update_id']) {
                $arguments['origin_in'] = $stagingData['update_id'];
            }
        }

        $this->versionManager->setCurrentVersionId($update->getId());

        $entity = $this->entityHydrator->hydrate($params['entityData']);
        $this->entityStaging->schedule(
            $entity,
            $update->getId(),
            $arguments
        );
        return true;
    }

    /**
     * Validate input parameters
     *
     * @param array $params
     * @return void
     */
    protected function validateParams(array $params)
    {
        foreach (['stagingData', 'entityData'] as $requiredParam) {
            if (!isset($params[$requiredParam])) {
                throw new \InvalidArgumentException(__('%1 is required parameter.', $requiredParam));
            }
            if (!is_array($params[$requiredParam])) {
                throw new \InvalidArgumentException(__('Invalid parameter %1.', $requiredParam));
            }
        }
    }
}