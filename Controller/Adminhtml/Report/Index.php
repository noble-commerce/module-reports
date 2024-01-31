<?php
declare(strict_types=1);

namespace NobleCommerce\Reports\Controller\Adminhtml\Report;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 * Controller for handling the index action of NobleCommerce Reports in the admin panel.
 */
class Index extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Execute action based on request and return result.
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        // Directly return the result page
        return $this->resultPageFactory->create();
    }

    /**
     * Check if action is allowed to be executed.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('NobleCommerce_Reports::report');
    }
}