<?php
/**
 * Grid Record Index Controller.
 * @category  Halfprice
 * @package   Halfprice_Designers
 * @author    Halfprice
 * @copyright Copyright (c) 2010-2017 Halfprice Software Private Limited Halfprice
Halfprice
 */
namespace Halfprice\Designers\Controller\Adminhtml\Grid;

class Proofs extends \Magento\Backend\App\Action
{
	protected $_coreSession;
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    private $resultPageFactory;
	protected $_adminSession;
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
		\Magento\Framework\Session\SessionManagerInterface $_coreSession,
		\Magento\Backend\Model\Auth\Session $adminSession,
		\Magento\User\Model\UserFactory $userFactory
    ) {
		parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
		$this->_coreSession = $_coreSession;
		$this->_adminSession = $adminSession;
		$this->userFactory = $userFactory;
		$this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
	  }
	/**
     * Mapped eBay Order List page.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
		/** get proof id **/
		$id = '';
		$resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Proofs'));
		$id=$this->getRequest()->getParam('id');
		$order = $this->_objectManager->create('Magento\Sales\Model\OrderRepository')->get($id);
		$inc_id = $order->getIncrementId();
		$customer = $order->getBillingAddress()->getFirstName();
		$state = $order->getStatus();
        $resultPage->getLayout()->initMessages();
        $resultPage->getLayout()->getBlock('lead-designer-block')->setIncId($customer); //assign id to block
        $resultPage->getLayout()->getBlock('lead-designer-block')->setId($id); //assign id to block
        $resultPage->getLayout()->getBlock('lead-designer-block')->setCustomer($customer); //assign id to block
        $resultPage->getLayout()->getBlock('lead-designer-block')->setStatus($state); //assign id to block
        return $resultPage;
    }
    /**
     * Check Order List Permission.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Halfprice_Designers::grid_proofs');
    }
}