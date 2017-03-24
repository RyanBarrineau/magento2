<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Staging\Model\Entity\Update\Action;

interface ActionInterface
{
    /**
     * Execute action
     *
     * @api
     * @param array $params
     * @return mixed
     */
    public function execute(array $params);
}
