<?php
declare(strict_types=1);

namespace NobleCommerce\Reports\Model;

use Magento\Framework\View\Element\UiComponent\DataProvider\Reporting;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Api\FilterBuilder;

/**
 * Class DataProviderConfig
 * Encapsulates configuration parameters for DataProvider.
 *
 * @package NobleCommerce\Reports\Model
 */
class DataProviderConfig
{
    public $reporting;
    public $searchCriteriaBuilder;
    public $request;
    public $filterBuilder;

    public function __construct(
        Reporting $reporting,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        RequestInterface $request,
        FilterBuilder $filterBuilder
    ) {
        $this->reporting = $reporting;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->request = $request;
        $this->filterBuilder = $filterBuilder;
    }
}