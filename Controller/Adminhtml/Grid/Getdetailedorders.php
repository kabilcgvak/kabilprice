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

class Getdetailedorders extends \Magento\Backend\App\Action
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
		/** send designers details for selected orders **/
		$post = $this->getRequest()->getPostValue();
		$orders =  $this->getRequest()->getPostValue('orders');
		$orders_list = explode(',',$orders);
		$role = $this->_coreSession->getRole();
		if($role=='Lead Designers' || $role=='Administrators')
		{
			try
			{$html = '<h3>Order Details</h3><table class="admin__table-primary dashboard-data"><tr><td>No.</td><td>Orders</td><td>Assigned On</td><td>Assigned Designer</td></tr>';
			  $j=1;
				for($i=0;$i<count($orders_list);$i++)
				{
					$designername='';$assignedon='';
						$order = $this->_objectManager->create('Magento\Sales\Model\Order')->load($orders_list[$i]); // get order current row.
						$designername = $order->getDesignerName();
						$inc_id = $order->getIncrementId();
						$assignedon = $order->getAssignedOn();
						$date=date_create($assignedon);
						$new_ass_date=date_format($date,"M d, Y H:i:s A");
						$html .= '<tr><td>'.$j.'</td><td>'.$inc_id.'</td><td>'.$new_ass_date.'</td><td>'.$designername.'</td></tr>';$j++;
				}
				$html .= "</table>";
				$roleNametest='Designers';
				$roleModel = $this->_objectManager->create('Magento\Authorization\Model\Role');
				$userModel = $this->_objectManager->create('Magento\User\Model\User');
				$roleModel = $roleModel->load($roleNametest, 'role_name');
				$userIds = $roleModel->getRoleUsers();
				$designer_select = '<div class="designer_selection"><div class="title"><h3>Designers</h3></div><div class="des_list"><select name="designer_id" id="designers_list" class="select select admin__control-select">
									<option value="">Select designer</option>';
				foreach($userIds as $userId)
				{$user='';$status='';
						$user = $userModel->load($userId);
						//echo $status = $user->getStatus();
						$status = $user->getDesignerStatus();
						if($status=='1')
						{$designer_select .= '<option value="'.$user->getUserId().'">'.$user->getUsername().'</option>';}
				}
                $designer_select .= '</select></div></div>';
			}
			catch(Exception $e)
			{
				$writer = new \Zend\Log\Writer\Stream(BP . '/var/log/getdetailedorders.log');
				$logger = new \Zend\Log\Logger();
				$logger->addWriter($writer);
				$logger->info($e->getMessage(), true);
			}	
			$response = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_JSON)
					->setData([
								'status'  => 'ok',
								'htmlData' => $html,
								'htmlDesignerSelect' => $designer_select
						]);
			return $response; 
		}
		else
		{
			$response = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_JSON)
					->setData([
								'status'  => 'Not a valid user',
						]);
		}
    }
}