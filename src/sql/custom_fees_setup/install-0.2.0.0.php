<?php

/** @var JosephLeedy_CustomFees_Model_Resource_Setup $this */

$installer = $this;

$installer->startSetup();

$installer->addAttribute(
    'quote',
    'custom_fees',
    [
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'required' => false,
        'comment' => 'Custom fees applied to the quote'
    ]
);
$installer->addAttribute(
    'order',
    'custom_fees',
    [
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'required' => false,
        'comment' => 'Custom fees applied to the order'
    ]
);

$installer->endSetup();
