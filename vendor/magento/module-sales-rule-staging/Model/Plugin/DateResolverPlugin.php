<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\SalesRuleStaging\Model\Plugin;

use Magento\SalesRule\Model\Rule as RuleModel;
use Magento\Staging\Api\UpdateRepositoryInterface;

class DateResolverPlugin
{
    /**
     * Start date attribute
     * @var string
     */
    private static $startDateAttribute = 'from_date';

    /**
     * End date attribute
     * @var string
     */
    private static $endDataAttribute = 'to_date';

    /**
     * @param \Magento\Staging\Api\UpdateRepositoryInterface
     */
    protected $updateRepository;

    /**
     * @param \Magento\Staging\Api\UpdateRepositoryInterface $updateRepository
     */
    public function __construct(
        UpdateRepositoryInterface $updateRepository
    ) {
        $this->updateRepository = $updateRepository;
    }

    /**
     * Provide campaign start date to the rule model.
     *
     * @param RuleModel $subject
     * @return void
     */
    public function beforeGetFromDate(RuleModel $subject)
    {
        // for update end date if different than created_in
        $resolvedTime = new \DateTime($this->resolveDate($subject)->getStartTime());
        if ($resolvedTime != $subject->getData(self::$startDateAttribute)) {
            $subject->setData(self::$startDateAttribute, $resolvedTime->format('Y-m-d'));
        }
    }

    /**
     * Provide campaign end date to the rule model.
     *
     * @param RuleModel $subject
     * @return void
     */
    public function beforeGetToDate(RuleModel $subject)
    {
        // for update end date if different than updated_in
        $resolvedTime = new \DateTime($this->resolveDate($subject)->getEndTime());
        if ($resolvedTime->format('Y-m-d') != $subject->getData(self::$endDataAttribute)) {
            $subject->setData(self::$endDataAttribute, $resolvedTime->format('Y-m-d'));
        }
    }

    /**
     * Resolve date using campaign id.
     * @param RuleModel $subject
     * @return \Magento\Staging\Api\Data\UpdateInterface
     */
    protected function resolveDate(RuleModel $subject)
    {
        $campaignId = $subject->getData('campaign_id');
        $versionId = $campaignId === null ? $subject->getData('created_in') : $campaignId;
        return $this->updateRepository->get($versionId);
    }
}
