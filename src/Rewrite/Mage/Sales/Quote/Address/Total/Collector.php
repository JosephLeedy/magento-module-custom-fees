<?php

class JosephLeedy_CustomFees_Rewrite_Mage_Sales_Quote_Address_Total_Collector
    extends Mage_Sales_Model_Quote_Address_Total_Collector
{
    protected function _initRetrievers()
    {
        parent::_initRetrievers();

        $foundKey = null;

        foreach ($this->_retrievers as $code => $retriever) {
            if ($retriever->getCode() !== 'custom_fees') {
                continue;
            }

            $foundKey = $code;

            break;
        }

        if ($foundKey === null) {
            return $this;
        }

        $customFees = Mage::getModel('custom_fees/config')->getCustomFees($this->_store->getId());
        $index = 1;

        array_walk(
            $customFees,
            function ($customFee) use ($foundKey, &$index) {
                $retriever = clone $this->_retrievers[$foundKey];

                $retriever->setCode($customFee['code']);

                $this->_retrievers[$foundKey + $index] = $retriever;

                ++$index;
            }
        );

        unset($this->_retrievers[$foundKey]);

        ksort($this->_retrievers);

        return $this;
    }
}