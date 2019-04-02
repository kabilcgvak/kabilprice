<?php

/**
 * Grid Grid Model.
 * @category  Halfprice
 * @package   Halfprice_Designers
 * @author    Halfprice
 * @copyright Copyright (c) 2010-2017 Halfprice Software Private Limited Halfprice
Halfprice
 */
namespace Halfprice\Designers\Model;

use Halfprice\Designers\Api\Data\GridInterface;

class Grid extends \Magento\Framework\Model\AbstractModel implements GridInterface
{
    /**
     * CMS page cache tag.
     */
    const CACHE_TAG = 'sales_order_grid';

    /**
     * @var string
     */
    protected $_cacheTag = 'sales_order_grid';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'sales_order_grid';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        //$this->_init('Halfprice\Designers\Model\ResourceModel\Grid');
    }
    /**
     * Get EntityId.
     *
     * @return int
     */
    public function getEntityId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * Set EntityId.
     */
    public function setEntityId($entityId)
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    /**
     * Get Title.
     *
     * @return varchar
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * Set Title.
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

   }
