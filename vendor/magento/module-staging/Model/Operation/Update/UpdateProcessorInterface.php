<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Staging\Model\Operation\Update;

interface UpdateProcessorInterface
{
    /**
     * Process update
     *
     * @param object $entity
     * @param int $versionId
     * @param int $rollbackId
     * @return object
     */
    public function process($entity, $versionId, $rollbackId = null);
}
