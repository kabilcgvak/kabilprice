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

class Index extends \Magento\Backend\App\Action
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
    }
	/**
     * Mapped eBay Order List page.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /* $this->_coreSession->start();
		$resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Halfprice_Designers::grid_list');
        $resultPage->getConfig()->getTitle()->prepend(__('Manage Assigned Orders'));
		$roleData = $this->_adminSession->getUser()->getRole()->getData();
		$userId = $this->_adminSession->getUser()->getUserId();
		$user = $this->userFactory->create()->load($userId);
		$role = $user->getRole();
		$this->_coreSession->setRole($role->getRoleName());
		$this->_coreSession->setUserid($this->_adminSession->getUser()->getUserId());
		$this->_coreSession->setUsername($this->_adminSession->getUser()->getUsername());
        return $resultPage; */
		$this->_coreSession->start();
	    $resultPage = $this->resultPageFactory->create();
		$roleData = $this->_adminSession->getUser()->getRole()->getData();
		$userId = $this->_adminSession->getUser()->getUserId();
		$user = $this->userFactory->create()->load($userId);
		$role = $user->getRole();
		$current_role = $role->getRoleName();
		if($current_role =='Administrators' || $current_role=='Lead Designers')
			{
				$resultPage->addHandle('grid_grid_index_lead');
				$resultPage->getConfig()->getTitle()->prepend(__('Manage Assigned Orders - Lead Designers'));
				$resultPage->setActiveMenu('Halfprice_Designers::grid_list');
			} //loads the layout of lead and admin layout xml file
		else if($current_role =='Designers')
			{
				$resultPage->addHandle('grid_grid_index_designers');
				$resultPage->getConfig()->getTitle()->prepend(__('Manage Assigned Orders - Designer'));
				$resultPage->setActiveMenu('Halfprice_Designers::grid_list');
			} //loads the layout of designers layout xml file
		//setting session
		$this->_coreSession->setRole($current_role);
		$this->_coreSession->setUserid($this->_adminSession->getUser()->getUserId());
		$this->_coreSession->setUsername($this->_adminSession->getUser()->getUsername());
        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Halfprice_Designers::grid_list');
    }
}
