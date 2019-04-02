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

class Designernote extends \Magento\Backend\App\Action
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
		if($role=='Lead Designers' || $role=='Administrators' || $role=='Designers')
		{
			$post = $this->getRequest()->getPostValue();
			//print_r($post);die();
			extract($post);
			$userid = $this->_coreSession->getUserid(); // get lead userid
			$username = $this->_coreSession->getUsername(); // get lead username
			try
			{
				$order = $this->_objectManager->create('\Magento\Sales\Model\Order')->load($orderid);
				$order->addStatusHistoryComment($designer_note." - updated by ".$username);
				$order->save(); 
				$response = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_JSON)
					->setData([
								'status'  => 'ok',
						]);
			}
			catch(Exception $e)
			{
				$writer = new \Zend\Log\Writer\Stream(BP . '/var/log/designernote.log');
				$logger = new \Zend\Log\Logger();
				$logger->addWriter($writer);
				$logger->info($e->getMessage(), true);
				$response = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_JSON)
					->setData([
								'status'  => $e->getMessage()
						]);
			}
		}
		else
		{
			$response = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_JSON)
					->setData([
								'status'  => 'You are not a valid user.'
						]);
		}
		return $response;
    }
}