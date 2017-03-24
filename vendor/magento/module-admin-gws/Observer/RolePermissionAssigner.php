<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\AdminGws\Observer;

class RolePermissionAssigner
{
    /**
     * @var array|null
     */
    protected $controllersMap = null;

    /**
     * @var \Magento\Store\Model\ResourceModel\Group\Collection
     */
    protected $storeGroupCollection;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Backend\Model\Auth\Session
     */
    protected $backendAuthSession;

    /**
     * @var \Magento\AdminGws\Model\ConfigInterface
     */
    protected $config;

    /**
     * @var \Magento\Framework\Acl\Builder
     */
    protected $aclBuilder;

    /**
     * @var \Magento\AdminGws\Model\CallbackInvoker
     */
    protected $callbackInvoker;

    /**
     * @var \Magento\Authorization\Model\Role
     */
    protected $role;

    /**
     * @param \Magento\Authorization\Model\Role $role
     * @param \Magento\Store\Model\ResourceModel\Group\Collection $storeGroups
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Backend\Model\Auth\Session $backendAuthSession
     * @param \Magento\AdminGws\Model\ConfigInterface  $config
     * @param \Magento\Framework\Acl\Builder $aclBuilder
     * @param \Magento\AdminGws\Model\CallbackInvoker $callbackInvoker
     */
    public function __construct(
        \Magento\Authorization\Model\Role $role,
        \Magento\Store\Model\ResourceModel\Group\Collection $storeGroups,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Backend\Model\Auth\Session $backendAuthSession,
        \Magento\AdminGws\Model\ConfigInterface $config,
        \Magento\Framework\Acl\Builder $aclBuilder,
        \Magento\AdminGws\Model\CallbackInvoker $callbackInvoker
    ) {
        $this->role = $role;
        $this->storeGroupCollection = $storeGroups;
        $this->storeManager = $storeManager;
        $this->backendAuthSession = $backendAuthSession;
        $this->config = $config;
        $this->aclBuilder = $aclBuilder;
        $this->callbackInvoker = $callbackInvoker;
    }

    /**
     * Assign group/website/store permissions to the admin role
     *
     * If all permissions are allowed, all possible websites / store groups / stores will be set
     * If only websites selected, all their store groups and stores will be set as well
     *
     * @param \Magento\Authorization\Model\Role $object
     * @return void
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function assignRolePermissions(\Magento\Authorization\Model\Role $object)
    {
        $gwsIsAll = (bool)(int)$object->getData('gws_is_all');
        $object->setGwsIsAll($gwsIsAll);
        $notEmptyFilter = function ($el) {
            return strlen($el) > 0;
        };
        if (!is_array($object->getGwsWebsites())) {
            $object->setGwsWebsites(array_filter(explode(',', (string)$object->getGwsWebsites()), $notEmptyFilter));
        }
        if (!is_array($object->getGwsStoreGroups())) {
            $object->setGwsStoreGroups(
                array_filter(explode(',', (string)$object->getGwsStoreGroups()), $notEmptyFilter)
            );
        }

        $storeGroupIds = $object->getGwsStoreGroups();

        // set all websites and store groups
        if ($gwsIsAll) {
            $object->setGwsWebsites(array_keys($this->storeManager->getWebsites()));
            foreach ($this->storeGroupCollection as $storeGroup) {
                $storeGroupIds[] = $storeGroup->getId();
            }
        } else {
            // set selected website ids
            // set either the set store group ids or all of allowed websites
            if (empty($storeGroupIds) && count($object->getGwsWebsites())) {
                foreach ($this->storeGroupCollection as $storeGroup) {
                    if (in_array($storeGroup->getWebsiteId(), $object->getGwsWebsites())) {
                        $storeGroupIds[] = $storeGroup->getId();
                    }
                }
            }
        }
        $object->setGwsStoreGroups(array_values(array_unique($storeGroupIds)));

        // determine and set store ids
        $storeIds = [];
        foreach ($this->storeManager->getStores() as $store) {
            if (in_array($store->getGroupId(), $object->getGwsStoreGroups())) {
                $storeIds[] = $store->getId();
            }
        }
        $object->setGwsStores($storeIds);

        // set relevant website ids from allowed store group ids
        $relevantWebsites = [];
        foreach ($this->storeGroupCollection as $storeGroup) {
            if (in_array($storeGroup->getId(), $object->getGwsStoreGroups())) {
                $relevantWebsites[] = $storeGroup->getWebsite()->getId();
            }
        }
        $object->setGwsRelevantWebsites(array_values(array_unique($relevantWebsites)));
    }

    /**
     * Deny acl level rules.
     *
     * @param string $level
     * @return $this
     */
    public function denyAclLevelRules($level)
    {
        foreach ($this->config->getDeniedAclResources($level) as $rule) {
            $this->aclBuilder->getAcl()->deny($this->backendAuthSession->getUser()->getAclRole(), $rule);
        }
        return $this;
    }
}
