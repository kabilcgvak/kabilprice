<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Halfprice\Designers\Block\Adminhtml;
class Reassigndesigners extends \Magento\Backend\Block\Template 
{
	protected $_template = 'Halfprice_Designers::html/reassign_popup.phtml';
	public function getFormKey()
    {
         return $this->formKey->getFormKey();
    }
}