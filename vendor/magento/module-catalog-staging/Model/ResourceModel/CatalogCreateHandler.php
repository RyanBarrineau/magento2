<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\CatalogStaging\Model\ResourceModel;

use Magento\Eav\Model\ResourceModel\CreateHandler;
use Magento\Eav\Model\ResourceModel\UpdateHandler;
use Magento\Staging\Model\VersionHistoryInterface;
use Magento\Framework\EntityManager\Operation\AttributeInterface;

/**
 * Class CatalogCreateHandler
 */
class CatalogCreateHandler implements AttributeInterface
{
    /**
     * @var CreateHandler
     */
    protected $createHandler;

    /**
     * @var UpdateHandler
     */
    protected $updateHandler;

    /**
     * @var VersionHistoryInterface
     */
    protected $versionHistory;

    /**
     * @var AttributeCopier
     */
    private $attributeCopier;

    /**
     * CatalogCreateHandler constructor.
     *
     * @param CreateHandler $createHandler
     * @param UpdateHandler $updateHandler
     * @param VersionHistoryInterface $versionHistory
     * @param AttributeCopier $attributeCopier
     */
    public function __construct(
        CreateHandler $createHandler,
        UpdateHandler $updateHandler,
        VersionHistoryInterface $versionHistory,
        AttributeCopier $attributeCopier
    ) {
        $this->createHandler = $createHandler;
        $this->updateHandler = $updateHandler;
        $this->versionHistory = $versionHistory;
        $this->attributeCopier = $attributeCopier;
    }

    /**
     * @param string $entityType
     * @param array $entityData
     * @param array $arguments
     * @return array
     */
    public function execute($entityType, $entityData, $arguments = [])
    {
        if (isset($arguments['origin_in'])) {
            $originId = $arguments['origin_in'];
        } elseif (isset($arguments['copy_origin_in'])) {
            $originId = $arguments['copy_origin_in'];
        } else {
            $originId = $this->versionHistory->getCurrentId();
        }
        if ($originId != $entityData['created_in']) {
            $this->attributeCopier->copy(
                $entityType,
                $entityData,
                $originId,
                $entityData['created_in']
            );
            return $this->updateHandler->execute($entityType, $entityData, $arguments);
        } else {
            return $this->createHandler->execute($entityType, $entityData, $arguments);
        }
    }
}
