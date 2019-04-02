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

class Assign extends \Magento\Backend\App\Action
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
	/** Re-Assign Process */
    public function execute()
    {
		/** assign designers to selected orders  **/
		$role = $this->_coreSession->getRole();
		if($role=='Lead Designers' || $role=='Administrators')
		{
			$post = $this->getRequest()->getPostValue();
			//print_r($post);
			extract($post);
			$designer = $this->userFactory->create()->load($designer_id);
			$designer_name = $designer->getUsername();
			$orders_ids = explode(',',$selected_orders_list);
			//$designer_id = '5';$designer_name='designer2';$html='';$orders_ids=array('1','2'); //sample data
			$lead_userid = $this->_coreSession->getUserid(); // get lead userid
			$lead_username = $this->_coreSession->getUsername(); // get lead username
			$objDate = $this->_objectManager->create('Magento\Framework\Stdlib\DateTime\DateTime'); // get current date and time
			$assigned_on = $objDate->gmtDate();
			try
			{
				for($i=0;$i<count($orders_ids);$i++) // reassign all orders to selected designer details
				{
					$order = $this->_objectManager->create('Magento\Sales\Model\Order')->load($orders_ids[$i]); // get order current row.
					$order->setDesignerId($designer_id);
					$order->setDesignerName($designer_name);
					$order->setAssignedOn($assigned_on);
					$order->setLeaddesignerId($lead_userid);
					$order->setLeaddesignerName($lead_username);
					$order->save();
				}
				return $this->resultRedirectFactory->create()->setPath('grid/grid/index');
			}
			catch(Exception $e)
			{
				$writer = new \Zend\Log\Writer\Stream(BP . '/var/log/assign.log');
				$logger = new \Zend\Log\Logger();
				$logger->addWriter($writer);
				$logger->info($e->getMessage(), true);
			}
		}
    }
}