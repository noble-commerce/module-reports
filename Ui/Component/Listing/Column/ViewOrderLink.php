<?php
declare(strict_types=1);

namespace NobleCommerce\Reports\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class ViewOrderLink
 *
 * @package NobleCommerce\Reports\Ui\Component\Listing\Column
 */
class ViewOrderLink extends Column
{
    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * ViewOrderLink constructor.
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param StoreManagerInterface $storeManager
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        StoreManagerInterface $storeManager,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->storeManager = $storeManager;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if (isset($item['entity_id']) && isset($item['view_order_link'])) {
                    $item[$this->getData('name')] = $this->getHtmlLink($item['view_order_link']);
                }
            }
        }
        return $dataSource;
    }

    /**
     * Generate the HTML link for viewing an order.
     *
     * @param string $url
     * @return string
     */
    private function getHtmlLink($url)
    {
        $linkText = __('View Order');

        return '<a class="action-menu-item" href="' . $url . '" target="_blank">' . $linkText . '</a>';
    }
}