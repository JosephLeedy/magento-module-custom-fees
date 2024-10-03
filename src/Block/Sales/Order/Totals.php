<?php

/**
 * Initializes and renders Custom Fees order total columns
 *
 * @method Mage_Sales_Block_Order_Totals|Mage_Sales_Block_Order_Invoice_Totals|Mage_Sales_Block_Order_Creditmemo_Totals getParentBlock()
 * @method string|null getBeforeCondition()
 * @method string|null getAfterCondition()
 */
class JosephLeedy_CustomFees_Block_Sales_Order_Totals extends Mage_Core_Block_Template
{
    /**
     * @return Mage_Sales_Model_Order|Mage_Sales_Model_Order_Invoice|Mage_Sales_Model_Order_Creditmemo|null
     */
    public function getSource()
    {
        return $this->getParentBlock()->getSource();
    }

    /**
     * @return $this
     */
    public function initTotals()
    {
        $source = $this->getSource();

        if ($source === null) {
            return $this;
        }

        if ($source instanceof Mage_Sales_Model_Order) {
            $order = $source;
        }

        if ($source instanceof Mage_Sales_Model_Order_Invoice || $source instanceof Mage_Sales_Model_Order_Creditmemo) {
            $order = $source->getOrder();
        }

        /** @var array $customFees */
        $customFees = unserialize($order->getData('custom_fees') ?: 'a:0:{}');

        if (count($customFees) === 0) {
            return $this;
        }

        reset($customFees);

        /** @var string|int $firstFeeKey */
        $firstFeeKey = key($customFees);
        $previousFeeCode = '';

        array_walk(
            $customFees,
            function (array $customFee, $key) use ($firstFeeKey, &$previousFeeCode) {
                $customFee['label'] = Mage::helper('custom_fees')->__($customFee['title']);

                unset($customFee['title']);

                $total = new Varien_Object($customFee);

                if ($key === $firstFeeKey) {
                    if ($this->getBeforeCondition() !== null) {
                        $this->getParentBlock()->addTotalBefore($total, $this->getBeforeCondition());
                    } else {
                        $this->getParentBlock()->addTotal($total, $this->getAfterCondition());
                    }
                } else {
                    $this->getParentBlock()->addTotal($total, $previousFeeCode);
                }

                $previousFeeCode = $customFee['code'];
            }
        );

        return $this;
    }
}
