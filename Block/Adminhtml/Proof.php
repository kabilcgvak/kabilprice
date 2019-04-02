<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Halfprice\Designers\Block\Adminhtml;
class Proof extends \Magento\Backend\Block\Template 
{
	 public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
		\Magento\Framework\Data\Form\FormKey $formKey,
		\Magento\Framework\App\Request\Http $request,
		\Magento\Customer\Model\AddressFactory $addressFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
		$this->formKey = $formKey;
		$this->_addressFactory = $addressFactory;
		$this->request = $request;
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
	public function getOrderedItems($orderId)
	{
		$order = $this->_objectManager->create('Magento\Sales\Model\Order')->load($orderId);
		$orderItems = $order->getAllItems();
		//print_r($orderItems);
		return $orderItems;
	}

	public function getRequest(){
		return $this->request;
	}

	public function getorder($orderId){
		$order = $this->_objectManager->create('Magento\Sales\Model\Order')->load($orderId);
		return $order;
	}

	public function getAddress($AddressId){
		$Address = $this->_addressFactory->create()->load($AddressId);
		return $Address;
	}
	
}