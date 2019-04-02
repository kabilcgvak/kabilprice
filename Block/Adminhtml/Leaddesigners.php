<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Halfprice\Designers\Block\Adminhtml;
class Leaddesigners extends \Magento\Backend\Block\Template 
{
	 public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Data\Form\FormKey $formKey,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->formKey = $formKey;
		$this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    }
    /**
     * get form key
     *
     * @return string
     */
    public function getFormKey()
    {
         return $this->formKey->getFormKey();
    }
	public function getRole()
	{
		$session = $this->_objectManager->create('Magento\Framework\Session\SessionManagerInterface');
		return $session->getRole();
	}
	//** get designers list **/
	public function getDesignersList()
	{
		$designers = array();
		$i=0;
		$userObject = $this->_objectManager->create('Magento\User\Model\UserFactory');
		/** Get user role to check logged roles **/
			$roleNametest='Designers';
			$roleModel = $this->_objectManager->create('Magento\Authorization\Model\Role');
			$userModel = $this->_objectManager->create('Magento\User\Model\User');
			$roleModel = $roleModel->load($roleNametest, 'role_name');
			$userIds = $roleModel->getRoleUsers();
				foreach($userIds as $userId)
				{$user='';$status='';
						$user = $userModel->load($userId);
						//echo $status = $user->getStatus();
						$status = $user->getDesignerStatus();
						//if($status=='1')
						{
							$designers[$i]['id'] = $user->getUserId();
							$designers[$i]['username'] = $user->getUsername();
							$designers[$i]['designer_status'] = $status;
							$i++;
						}
				}
			return $designers;
	}
}