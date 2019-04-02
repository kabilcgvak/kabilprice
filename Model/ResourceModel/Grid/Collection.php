<?php
    /**
     * Halfprice Grid collection
     *
     * @category    Halfprice
     * @package     Halfprice_Grid
     * @author      Halfprice Software Private Limited
     *
     */
namespace Halfprice\Designers\Model\ResourceModel\Grid;
 
/* use required classes */
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Psr\Log\LoggerInterface;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
 
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';
     /**
     * @param EntityFactoryInterface $entityFactory,
     * @param LoggerInterface        $logger,
     * @param FetchStrategyInterface $fetchStrategy,
     * @param ManagerInterface       $eventManager,
     * @param StoreManagerInterface  $storeManager,
     * @param AdapterInterface       $connection,
     * @param AbstractDb             $resource
     */
    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Framework\DB\Adapter\AdapterInterface $connection = null,
        \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null
    ) {
        $this->_init('Halfprice\Designers\Model\Grid', 'Halfprice\Designers\Model\ResourceModel\Grid');
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
    }
     
    protected function _initSelect()
    {
        parent::_initSelect();
		/** Get User ID to filter sales orders **/
		$userName = '';$userId='';
		$objectmanager =  \Magento\Framework\App\ObjectManager::getInstance();
		$adminsession = $objectmanager->create('Magento\Backend\Model\Auth\Session');
		$userObject = $objectmanager->create('Magento\User\Model\UserFactory');
		$userId = $adminsession->getUser()->getUserId();
		$userName = $adminsession->getUser()->getUsername();
		/** Get user role to check logged roles **/
		$userRole = $userObject->create()->load($userId);
		$role = $userRole->getRole();
		$roleName = $role->getRoleName();
		if($roleName=='Administrators' || $roleName=='Lead Designers')
		{
				$this->getSelect()->joinLeft(
				['secondTable' => $this->getTable('admin_user')], //2nd table name by which you want to join mail table
				'main_table.designer_name = secondTable.username');
				/* $this->getSelect()->joinLeft(
				['thirdTable'=>$this->getTable('sales_order_address')],
				'main_table.entity_id = thirdTable.parent_id', ['customername'=>'thirdTable.firstname']); */
		}
		else if($roleName=='Designers')
		{
			$this->getSelect()->joinLeft(
				['secondTable' => $this->getTable('admin_user')], //2nd table name by which you want to join mail table
				'main_table.designer_name = secondTable.username')->where("secondTable.username = '$userName'");
		}
		
    }
}
