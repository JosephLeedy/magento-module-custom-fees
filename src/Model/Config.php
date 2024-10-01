<?php

class JosephLeedy_CustomFees_Model_Config
{
    const CONFIG_PATH_CUSTOM_FEES = 'sales/custom_order_fees/custom_fees';

    /**
     * @param int|string|null $storeId
     * @return array[]
     */
    public function getCustomFees($storeId = null, $includeZeroValues = true)
    {
        $customFees = Mage::getStoreConfig(self::CONFIG_PATH_CUSTOM_FEES, $storeId) ?: [];

        if (!is_array($customFees)) {
            $customFees =  unserialize($customFees) ?: [];
        }

        if (!$includeZeroValues) {
            $customFees = array_filter(
                $customFees,
                function ($customFee) {
                    return $customFee['value'] != 0;
                }
            );
        }

        return $customFees;
    }
}