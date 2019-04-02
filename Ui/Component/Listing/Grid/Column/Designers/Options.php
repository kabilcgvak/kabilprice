<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Halfprice\Designers\Ui\Component\Listing\Grid\Column\Designers;
/**
 * Class Options
 */
 use Magento\Framework\Data\OptionSourceInterface;
class Options implements OptionSourceInterface
{
    /**
     * @var array
     */
    protected $_options;

    public function toOptionArray()
    {
		$log_userId = '';$search_id='';
		$objectManager =  \Magento\Framework\App\ObjectManager::getInstance();
			$adminsession = $objectManager->create('Magento\Backend\Model\Auth\Session');
		/** Get User ID to filter sales orders **/
		if ($this->_options === null)
		{
				
			$this->_options = [['label' => '', 'value' => '']];
			$roleNametest = "Designers";
			
		$userObject = $objectManager->create('Magento\User\Model\UserFactory');
		$log_userId = $adminsession->getUser()->getUserId();
		/** Get user role to check logged roles **/
		$userRole = $userObject->create()->load($log_userId);
		$role = $userRole->getRole();
		$roleName = $role->getRoleName();
		if($roleName=='Designers')
		{
			$search_id = 'No';
		}
			$roleModel = $objectManager->create('Magento\Authorization\Model\Role');
			$userModel = $objectManager->create('Magento\User\Model\User');
			$roleModel = $roleModel->load($roleNametest, 'role_name');
			if($roleModel->getId()) {
				$userIds = $roleModel->getRoleUsers();
				if($search_id=='')
				{
					foreach($userIds as $userId) {
					$user = $userModel->load($userId);      
				  $this->_options[] = ['label' => $user->getUsername(),'value' => $user->getUsername()];
				  }
				}
				else if($search_id=='No')
				{
						foreach($userIds as $userId)
						{
							if($log_userId==$userId)
							{
					$user = $userModel->load($userId);      
				  $this->_options[] = ['label' => $user->getUsername(),'value' => $user->getUsername()];
				  break;
							}
				  }
				}
			}
		}
	return $this->_options;
}
}