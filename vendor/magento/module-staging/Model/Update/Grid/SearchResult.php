<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Staging\Model\Update\Grid;

use Magento\Framework\Api;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface as FetchStrategy;
use Magento\Framework\Data\Collection\EntityFactoryInterface as EntityFactory;
use Magento\Staging\Model\Update\Includes\Retriever as IncludesRetriever;
use Magento\Staging\Model\Update\Source\Status;
use Psr\Log\LoggerInterface as Logger;
use Magento\Staging\Api\Data\UpdateInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult as AbstractSearchResult;
use Magento\Framework\DB\Select;
use Magento\Staging\Model\StagingList;
use Magento\Staging\Model\VersionHistoryInterface;
use Magento\Staging\Model\Update\Includes\Hierarchy;

/**
 * SearchResult for updates
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class SearchResult extends AbstractSearchResult
{
    /**
     * @var string[]
     */
    protected $fieldsMap = [
        'end_time' => 'rollbacks.start_time'
    ];

    /**
     * @var StagingList
     */
    protected $stagingList;

    /**
     * @var VersionHistoryInterface
     */
    protected $versionHistory;

    /**
     * @var IncludesRetriever
     */
    protected $includes;

    /**
     * @var Hierarchy
     */
    private $hierarchy;

    /**
     * @param EntityFactory $entityFactory
     * @param Logger $logger
     * @param FetchStrategy $fetchStrategy
     * @param EventManager $eventManager
     * @param string $mainTable
     * @param string $resourceModel
     * @param StagingList $stagingList
     * @param VersionHistoryInterface $versionHistory
     * @param IncludesRetriever $includes
     * @param Hierarchy $hierarchy
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        EntityFactory $entityFactory,
        Logger $logger,
        FetchStrategy $fetchStrategy,
        EventManager $eventManager,
        $mainTable,
        $resourceModel,
        StagingList $stagingList,
        VersionHistoryInterface $versionHistory,
        IncludesRetriever $includes,
        Hierarchy $hierarchy
    ) {
        $this->stagingList = $stagingList;
        $this->versionHistory = $versionHistory;
        $this->includes = $includes;
        $this->hierarchy = $hierarchy;
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $mainTable, $resourceModel);
    }

    /**
     * Init select
     *
     * @return void
     */
    protected function _initSelect()
    {
        parent::_initSelect();
        $this->getSelect()->where(sprintf('main_table.%s IS NULL', UpdateInterface::IS_ROLLBACK));
        $this->getSelect()->joinLeft(
            ['rollbacks' => $this->getMainTable()],
            sprintf(
                '%s.%s = %s.%s',
                'main_table',
                'rollback_id',
                'rollbacks',
                'id'
            ),
            [
                'end_time' => 'start_time'
            ]
        );
    }

    /**
     * Add field filter to collection
     *
     * @see self::_getConditionSql for $condition
     *
     * @param string|array $field
     * @param null|string|array $condition
     * @return $this
     */
    public function addFieldToFilter($field, $condition = null)
    {
        if (is_array($field)) {
            foreach ($field as $key => $value) {
                $field[$key] = $this->addTableToField($value);
            }
        } else {
            $field = $this->addTableToField($field);
        }

        return parent::addFieldToFilter($field, $condition);
    }

    /**
     * Add corresponding table to requested field using fields map
     *
     * @param string $field
     * @return string
     */
    protected function addTableToField($field)
    {
        return isset($this->fieldsMap[$field]) ? $this->fieldsMap[$field] : sprintf('main_table.%s', $field);
    }

    /**
     * @inheritDoc
     */
    protected function _afterLoad()
    {
        $this->prepareData();
        return parent::_afterLoad();
    }

    /**
     * Prepare status and includes staging data
     *
     * @throws \Zend_Db_Select_Exception
     * @return void
     */
    protected function prepareData()
    {
        $includesData = $this->includes->getIncludes($this->getAllIds());
        $includesData = $this->hierarchy->changeIdToLast($includesData);
        foreach ($this->_items as $id => $item) {
            if ($item->getMovedTo()) {
                unset($this->_items[$id]);
                continue;
            }
            $includes = [];
            foreach ($includesData as $includeData) {
                if ($includeData['created_in'] == $id) {
                    if (isset($includes[$includeData['entity_type']])) {
                        $includes[$includeData['entity_type']]['count'] += $includeData['includes'];
                    } else {
                        $includes[$includeData['entity_type']] = [
                            'entityType' => $includeData['entity_type'],
                            'entityLabel' => __($includeData['entity_type']),
                            'count' => $includeData['includes']
                        ];
                    }
                }
            }
            $item->setData('includes', array_values($includes));
            $item->setData(
                'status',
                ($id > $this->versionHistory->getCurrentId()) ? Status::STATUS_UPCOMING : Status::STATUS_ACTIVE
            );
        }
    }
}
