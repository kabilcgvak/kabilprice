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
		$adminuser = 'admin_user';
        if (version_compare($context->getVersion(), '1.0.3') < 1) {
            //Order Grid table - Join Designers
            $setup->getConnection()
                ->addColumn(
                    $setup->getTable($orderGridTable),
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
                    $setup->getTable($orderGridTable),
                    'leaddesigner_id',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
						'nullable' => false,
						'comment' => 'Lead Designers'
                    ]
                );
				 $setup->getConnection()
                ->addColumn(
                    $setup->getTable($orderGridTable),
                    'designer_name',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
						'nullable' => false,
						'comment' => 'Designers Name'
                    ]
                );
				 $setup->getConnection()
                ->addColumn(
                    $setup->getTable($orderGridTable),
                    'leaddesigner_name',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
						'nullable' => false,
						'comment' => 'Lead Designers Name'
                    ]
                );
        }
		if (version_compare($context->getVersion(), '1.0.4') < 1) {
            //Order Grid table - Join Designers
            $setup->getConnection()
                ->addColumn(
                    $setup->getTable($adminuser),
                    'designer_status',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
						'nullable' => false,
						'default'  => '1',
						'comment' => 'Designer Status'
                    ]
                ); 
				
        }
        if (version_compare($context->getVersion(), '1.0.6') < 1) {
            //Order Grid table - Join Designers
            $setup->getConnection()
                ->addColumn(
                    $setup->getTable($orderGridTable),
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