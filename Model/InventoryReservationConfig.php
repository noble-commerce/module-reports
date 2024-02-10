<?php
declare(strict_types=1);

namespace NobleCommerce\Reports\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class InventoryReservationConfig
 * Encapsulates configuration parameters for InventoryReservation.
 *
 * @package NobleCommerce\Reports\Model
 */
class InventoryReservationConfig
{
    public $storeManager;
    public $urlBuilder;
    public $scopeConfig;

    public function __construct(
        StoreManagerInterface $storeManager,
        UrlInterface $urlBuilder,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->storeManager = $storeManager;
        $this->urlBuilder = $urlBuilder;
        $this->scopeConfig = $scopeConfig;
    }
}