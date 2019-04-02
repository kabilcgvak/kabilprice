<?php
namespace Halfprice\Designers\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
		$orderGridTable = 'sales_order_grid';
        $orderTable = 'sales_order';

        if (version_compare($context->getVersion(), '1.0.7') < 1) {
            //Order Grid table - Join Designers
            $setup->getConnection()
                ->addColumn(
                    $setup->getTable($orderTable),
                    'designer_id',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
						'nullable' => false,
						'comment' => 'Designers'
                    ]
                ); 
				//Order Grid table - Lead Designers
            $setup->getConnection()
                 ->addColumn(
                    $setup->getTable($orderTable),
                    'leaddesigner_id',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
						'nullable' => false,
						'comment' => 'Lead Designers'
                    ]
                );
				 $setup->getConnection()
                ->addColumn(
                    $setup->getTable($orderTable),
                    'designer_name',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
						'nullable' => false,
						'comment' => 'Designers Name'
                    ]
                );
				 $setup->getConnection()
                ->addColumn(
                    $setup->getTable($orderTable),
                    'leaddesigner_name',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
						'nullable' => false,
						'comment' => 'Lead Designers Name'
                    ]
                );
                 $setup->getConnection()
                ->addColumn(
                    $setup->getTable($orderTable),
                    'assigned_on',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                        'nullable' => false,
                        'comment' => 'Designer assigned on'
                    ]
                ); 
                
        } 
         if (version_compare($context->getVersion(), '1.0.7') < 1) {
            //Order Grid table - Join Designers
            $setup->getConnection()
                ->addColumn(
                    $setup->getTable($orderTable),
                    'assigned_on',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                        'nullable' => false,
                        'comment' => 'Designer assigned on'
                    ]
                ); 
            }
        $setup->endSetup();
    }
}
?>