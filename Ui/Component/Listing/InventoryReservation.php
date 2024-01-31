<?php
declare(strict_types=1);

namespace NobleCommerce\Reports\Ui\Component\Listing;

use NobleCommerce\Reports\Model\InventoryReservationConfig;
use NobleCommerce\Reports\Model\DataProviderConfig;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider;
use Magento\Framework\UrlInterface;
use Zend_Db_Select;
use Zend_Db_Expr;

/**
 * Data provider for inventory reservation reports.
 */
class InventoryReservation extends DataProvider
{
    /**
     * @var InventoryReservationConfig
     */
    private $config;

    /**
     * @var DataProviderConfig
     */
    private $dataProviderConfig;

    /**
     * Constructor.
     *
     * @param InventoryReservationConfig $config
     * @param DataProviderConfig $dataProviderConfig
     * @param array $meta
     * @param array $data
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     */
    public function __construct(
        InventoryReservationConfig $config,
        DataProviderConfig $dataProviderConfig,
        array $meta = [],
        array $data = [],
        string $name = 'inventory_reservation',
        string $primaryFieldName = 'reservation_id',
        string $requestFieldName = 'entity_id'
    ) {
        $this->config = $config;
        $this->dataProviderConfig = $dataProviderConfig;
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $dataProviderConfig->reporting,
            $dataProviderConfig->searchCriteriaBuilder,
            $dataProviderConfig->request,
            $dataProviderConfig->filterBuilder,
            $meta,
            $data
        );
    }

    /**
     * Get search result.
     *
     * @return SearchResultInterface
     */
    public function getSearchResult(): SearchResultInterface
    {
        $adminUrlCustomPath = $this->config->scopeConfig->getValue('admin/url/custom_path');
        $adminPath = $adminUrlCustomPath ?? 'admin';
        $baseUrl = $this->config->storeManager->getNobleCommerce()->getBaseUrl(UrlInterface::URL_TYPE_WEB);
        $adminBaseUrl = rtrim($baseUrl, '/') . '/' . ltrim($adminPath, '/');
        $collection = $this->reporting->search($this->getSearchCriteria());
        $searchCriteria = $this->getSearchCriteria();
        $currentPage = $searchCriteria->getCurrentPage() ?? 1;
        $pageSize = $searchCriteria->getPageSize() ?? 20;
        $collection->setPageSize($pageSize);
        $collection->setCurPage($currentPage);

        $collection->getSelect()->reset(Zend_Db_Select::COLUMNS)
            ->columns([
                'entity_id' => 'ir.reservation_id',
                'increment_id' => 'main_table.increment_id',
                'created_at' => 'main_table.created_at',
                'updated_at' => 'main_table.updated_at',
                'state' => 'main_table.state',
                'status' => 'main_table.status',
                'view_order_link' => new Zend_Db_Expr("CONCAT('$adminBaseUrl', '/sales/order/view/order_id/', main_table.entity_id)"),
                'create_shipment_link' => new Zend_Db_Expr("CONCAT('$adminBaseUrl', '/order_shipment/new/order_id/', main_table.entity_id)")
            ])
            ->joinInner(
                ['ir' => $collection->getTable('inventory_reservation')],
                'main_table.increment_id = JSON_UNQUOTE(JSON_EXTRACT(ir.metadata, "$.object_increment_id"))',
                []
            )
            ->where('ir.quantity < ?', 0)
            ->group('main_table.entity_id');

        return $collection;
    }
}