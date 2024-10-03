<?php

class JosephLeedy_CustomFees_Model_Total_Creditmemo_CustomFees extends Mage_Sales_Model_Order_Creditmemo_Total_Abstract
{
    /**
     * Collect custom fees totals
     */
    public function collect(Mage_Sales_Model_Order_Creditmemo $creditmemo)
    {
        parent::collect($creditmemo);

        /** @var array $customFees */
        $customFees = unserialize($creditmemo->getOrder()->getData('custom_fees') ?: 'a:0:{}');

        if (count($customFees) === 0) {
            return $this;
        }

        $baseTotalCustomFees = array_sum(array_column($customFees, 'base_value'));
        $totalCustomFees = array_sum(array_column($customFees, 'value'));

        $creditmemo->setBaseGrandTotal($creditmemo->getBaseGrandTotal() + $baseTotalCustomFees);
        $creditmemo->setGrandTotal($creditmemo->getGrandTotal() + $totalCustomFees);

        return $this;
    }
}
