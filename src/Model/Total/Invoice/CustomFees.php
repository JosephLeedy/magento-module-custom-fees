<?php

class JosephLeedy_CustomFees_Model_Total_Invoice_CustomFees extends Mage_Sales_Model_Order_Invoice_Total_Abstract
{
    /**
     * Collect custom fees totals
     */
    public function collect(Mage_Sales_Model_Order_Invoice $invoice)
    {
        parent::collect($invoice);

        /** @var array $customFees */
        $customFees = unserialize($invoice->getOrder()->getData('custom_fees') ?: 'a:0:{}');

        if (count($customFees) === 0) {
            return $this;
        }

        $baseTotalCustomFees = array_sum(array_column($customFees, 'base_value'));
        $totalCustomFees = array_sum(array_column($customFees, 'value'));

        $invoice->setBaseGrandTotal($invoice->getBaseGrandTotal() + $baseTotalCustomFees);
        $invoice->setGrandTotal($invoice->getGrandTotal() + $totalCustomFees);

        return $this;
    }
}
