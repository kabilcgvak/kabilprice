<?php

 
namespace Halfprice\Designers\Block\Adminhtml\Lineitem;

class Itemview extends \Magento\Backend\Block\Template
{

    /**
     * Constructor
     *
     * @param \Magento\Backend\Block\Template\Context  $context
     * @param array $data
     */
     public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Data\Form\FormKey $formKey,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Customer\Model\AddressFactory $addressFactory,
        \Magento\Sales\Api\OrderItemRepositoryInterface $orderItemRepository,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->formKey = $formKey;
        $this->_addressFactory = $addressFactory;
        $this->request = $request;
         $this->orderItemRepository = $orderItemRepository;
        $this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    }

    /* get order Item collection */
    public function getOrderItem($itemIid = 4)
    {
        $itemCollection = $this->orderItemRepository->get($itemIid);
        return $itemCollection;
    }

    
}