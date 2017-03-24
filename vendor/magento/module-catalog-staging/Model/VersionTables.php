<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\CatalogStaging\Model;

class VersionTables extends \Magento\Framework\DataObject
{
    /**
     * @return mixed
     */
    public function getVersionTables()
    {
        return (array)$this->getData('version_tables');
    }
}
