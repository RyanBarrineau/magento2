<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Staging\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\VersionControl\AbstractDb;
use Magento\Framework\Stdlib\DateTime\DateTime;

/**
 * Staging update resource
 */
class Update extends AbstractDb
{
    /**
     * Use is object new method for save of object
     *
     * @var bool
     */
    protected $_useIsObjectNew = true;

    /**
     * Primary key auto increment flag
     *
     * @var bool
     */
    protected $_isPkAutoIncrement = false;

    /**
     * Event prefix
     *
     * @var string
     */
    protected $_eventPrefix = 'staging_update_resource';

    /**
     * @var array
     */
    private $versionCache;

    /**
     * Model initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('staging_update', 'id');
    }

    /**
     * Retrieve max version id for requested datetime
     *
     * @param int $timestamp
     * @return string
     */
    public function getMaxIdByTime($timestamp)
    {
        if (!isset($this->versionCache[$timestamp])) {
            $date = new \DateTime();
            $date->setTimestamp($timestamp);
            $select = $this->getConnection()->select()
                ->from($this->getMainTable())
                ->where('start_time <= ?', $date->format('Y-m-d H:i:s'))
                ->order(['id ' . \Magento\Framework\DB\Select::SQL_DESC])
                ->limit(1);
            $this->versionCache[$timestamp] = $this->getConnection()->fetchOne($select);
        }
        return $this->versionCache[$timestamp];
    }

    /**
     * @inheritdoc
     */
    protected function processAfterSaves(\Magento\Framework\Model\AbstractModel $object)
    {
        if ($object->getOldId() && $object->getOldId() != $object->getId() && !$object->getIsRollback()) {
            $this->getConnection()->update(
                $this->getMainTable(),
                ['moved_to' => $object->getId()],
                ['id = ?' => $object->getOldId()]
            );
        }
        parent::processAfterSaves($object);
    }
}
