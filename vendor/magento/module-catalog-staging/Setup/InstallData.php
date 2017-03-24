<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\CatalogStaging\Setup;

use \Magento\Catalog\Model\Category;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class InstallData implements InstallDataInterface
{
    /**
     * @var \Magento\CatalogStaging\Setup\CatalogCategorySetup
     */
    protected $catalogCategorySetup;

    /**
     * @var \Magento\Staging\Api\UpdateRepositoryInterface
     */
    private $updateRepository;

    /**
     * @var \Magento\Staging\Api\Data\UpdateInterfaceFactory
     */
    private $updateFactory;

    /**
     * @var \Magento\Staging\Model\VersionManagerFactory
     */
    private $versionManagerFactory;

    /**
     * @var \Magento\Framework\App\State
     */
    private $state;

    /**
     * @var \Magento\Catalog\Model\CategoryFactory
     */
    private $categoryCollectionFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var CatalogProductSetupFactory
     */
    private $catalogProductSetupFactory;

    /**
     * @param \Magento\Staging\Api\UpdateRepositoryInterface $updateRepository
     * @param \Magento\Staging\Api\Data\UpdateInterfaceFactory $updateFactory
     * @param \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory
     * @param \Magento\Framework\App\State $state
     * @param \Magento\Staging\Model\VersionManagerFactory $versionManagerFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param CatalogProductSetupFactory $catalogProductSetupFactory
     */
    public function __construct(
        \Magento\Staging\Api\UpdateRepositoryInterface $updateRepository,
        \Magento\Staging\Api\Data\UpdateInterfaceFactory $updateFactory,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
        \Magento\Framework\App\State $state,
        \Magento\Staging\Model\VersionManagerFactory $versionManagerFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        CatalogProductSetupFactory $catalogProductSetupFactory
    ) {
        $this->updateRepository = $updateRepository;
        $this->updateFactory = $updateFactory;
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->state = $state;
        $this->versionManagerFactory = $versionManagerFactory;
        $this->storeManager = $storeManager;
        $this->catalogProductSetupFactory = $catalogProductSetupFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Exception
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        // Emulate area for category migration
        $this->state->emulateAreaCode(
            \Magento\Backend\App\Area\FrontNameResolver::AREA_CODE,
            [$this, 'updateCategories'],
            []
        );
        // Emulate area for products migration
        $this->state->emulateAreaCode(
            \Magento\Backend\App\Area\FrontNameResolver::AREA_CODE,
            [$this, 'updateProducts'],
            [$setup]
        );

        $this->migrateCatalogProducts($setup);
    }

    /**
     * Fill in fields, created for staging support, with default values.
     *
     * @param ModuleDataSetupInterface $setup
     * @return void
     */
    public function updateProducts(ModuleDataSetupInterface $setup)
    {
        $existingProductIdsSelect = $setup->getConnection()->select()
            ->from($setup->getTable('catalog_product_entity'), ['sequence_value' => 'row_id'])
            ->setPart('disable_staging_preview', true);

        $setup->getConnection()->query(
            $setup->getConnection()->insertFromSelect(
                $existingProductIdsSelect,
                $setup->getTable('sequence_product'),
                ['sequence_value'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INSERT_IGNORE
            )
        );

        $setup->getConnection()->update(
            $setup->getTable('catalog_product_entity'),
            [
                'entity_id' => new \Zend_Db_Expr('row_id'),
                'created_in' => 0,
                'updated_in' => \Magento\Staging\Model\VersionManager::MAX_VERSION
            ]
        );
    }

    /**
     * @return void
     */
    public function updateCategories()
    {
        $categories = $this->categoryCollectionFactory->create()->addFieldToFilter('parent_id', ['neq' => '0']);

        $this->updateCategoriesScheduleTime($categories);
    }

    /**
     * @param \Magento\Catalog\Model\ResourceModel\Category\Collection $categories
     * @return void
     */
    private function updateCategoriesScheduleTime(
        \Magento\Catalog\Model\ResourceModel\Category\Collection $categories
    ) {
        $allStoreId = $this->storeManager->getStores(true);
        $versionManager = $this->versionManagerFactory->create();
        foreach ($categories as $category) {
            foreach ($allStoreId as $storeId) {

                /** @var $category \Magento\Catalog\Model\Category */
                $category->setStoreId($storeId);
                $category->load($category['id']);

                if ($this->checkCategoryForUpdate($category)) {
                    $versionManager->getVersion()->setId(
                        $this->updateCustomDesignDateFields($category)->getId()
                    );

                    $category->setData('custom_design_from');
                    $category->setData('custom_design_to');
                    $category->save();
                }
            }
        }
    }

    /**
     * @param Category $category
     * @return bool
     */
    private function checkCategoryForUpdate(\Magento\Catalog\Model\Category $category)
    {
        return $this->hasCategoryValueInNotDefaultStore($category) || $this->hasCategoryValueInDefaultStore($category);
    }

    /**
     * @param Category $category
     * @return bool
     */
    private function hasCategoryValueInNotDefaultStore(\Magento\Catalog\Model\Category $category)
    {
        return $category->getExistsStoreValueFlag('custom_design_from')
        || $category->getExistsStoreValueFlag('custom_design_to');
    }

    /**
     * @param Category $category
     * @return bool
     */
    private function hasCategoryValueInDefaultStore(\Magento\Catalog\Model\Category $category)
    {
        return ($category->getStoreId() === \Magento\Store\Model\Store::DEFAULT_STORE_ID
            && $category->getData('custom_design_to')
            || $category->getStoreId() === \Magento\Store\Model\Store::DEFAULT_STORE_ID
            && $category->getData('custom_design_from'));
    }

    /**
     * @param Category $category
     * @return \Magento\Staging\Api\Data\UpdateInterface
     */
    private function updateCustomDesignDateFields(Category $category)
    {
        /** @var \Magento\Staging\Api\Data\UpdateInterface $update */
        $update = $this->updateFactory->create();
        $update->setName($category->getData('name'));

        if ($category->getData('custom_design_from')) {
            $date = new \DateTime($category->getData('custom_design_from'), new \DateTimeZone('UTC'));
            $update->setStartTime($date->format('Y-m-d 00:00:00'));
        } else {
            $date = new \DateTime('now', new \DateTimeZone('UTC'));
            $update->setStartTime($date->format('Y-m-d 00:00:00'));
        }

        if ($category->getData('custom_design_to')) {
            $date = new \DateTime($category->getData('custom_design_to'), new \DateTimeZone('UTC'));
            $update->setEndTime($date->format('Y-m-d 23:59:59'));
        }

        $update->setIsCampaign(false);
        $this->updateRepository->save($update);

        return $update;
    }

    /**
     * Migrate catalog products
     *
     * @param ModuleDataSetupInterface $setup
     * @return void
     */
    private function migrateCatalogProducts(ModuleDataSetupInterface $setup)
    {
        /** @var CatalogProductSetup $catalogProductSetup */
        $catalogProductSetup = $this->catalogProductSetupFactory->create();
        $catalogProductSetup->execute($setup);
    }
}
