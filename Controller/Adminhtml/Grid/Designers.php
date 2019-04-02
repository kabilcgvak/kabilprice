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

class Designers extends \Magento\Backend\App\Action
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
		/** send designers list with updated status - userid **/
		$post = $this->getRequest()->getPostValue();
		$userid = '';$html='';$designers_status=array();
		extract($post);
		try
		{
			for($i=0;$i<count($designers_ids);$i++)
			{$checked='';
					$userid = $designers_ids[$i];
					if(in_array($userid,$designers_status))
						{$designer_status = '1';$checked='checked';}
					else
						{$designer_status = '0';$checked='';}
					$user = $this->userFactory->create()->load($userid);
					$user->setDesignerStatus($designer_status);
					$user->save();
					$html .= '<tr title="" class="even_clickable"><td class="col-items col-number "></td><td class="col-customer"><input name="designers_ids[]" value="'.$userid.'" type="hidden"><input name="designers_status[]" value="'.$userid.'" type="checkbox" '.$checked.'> '.$user->getUsername().'</td></tr>';
			}
		}
		catch(Exception $e)
		{
			$writer = new \Zend\Log\Writer\Stream(BP . '/var/log/designers.log');
			$logger = new \Zend\Log\Logger();
			$logger->addWriter($writer);
			$logger->info($e->getMessage(), true);
		}	
		$response = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_JSON)
				->setData([
							'status'  => 'ok',
							'htmlData' => $html
					]);
        return $response;
    }
}