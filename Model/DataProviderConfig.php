<?php
declare(strict_types=1);

namespace NobleCommerce\Reports\Model;

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\Reporting;

/**
 * Class DataProviderConfig
 * Encapsulates configuration parameters for DataProvider.
 *
 */
class DataProviderConfig
{
    public Reporting $reporting;
    public SearchCriteriaBuilder $searchCriteriaBuilder;
    public RequestInterface $request;
    public FilterBuilder $filterBuilder;

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
