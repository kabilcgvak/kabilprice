<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Halfprice\Designers\Ui\DataProvider\Listing;

/**
 * Provide information about current store and currency for product listing ui component
 */
class DataProvider extends \Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider
{
    public function getData()
    {
        $data = [];
        $data['visible'] = false;
		return $data;
    }
}
