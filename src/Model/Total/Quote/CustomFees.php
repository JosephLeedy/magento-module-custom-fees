<?php

class JosephLeedy_CustomFees_Model_Total_Quote_CustomFees extends Mage_Sales_Model_Quote_Address_Total_Abstract
{
    const CODE = 'custom_fees';

    /**
     * Collect custom fees totals
     */
    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        parent::collect($address);

        if (count($this->_getAddressItems($address)) === 0) {
            return $this;
        }

        $quote = $address->getQuote();

        if ($quote === null) {
            Mage::log(
                Mage::helper('custom_fees')
                    ->__(
                        'Could not collect custom fees for address with ID "%s" because it does not have an '
                        . 'associated quote.',
                        $address->getId()
                    ),
                Zend_Log::CRIT
            );

            return $this;
        }

        $store = $quote->getStore();
        list($baseCustomFees, $localCustomFees) = $this->getCustomFees($store);
        $customFees = $baseCustomFees;

        array_walk(
            $baseCustomFees,
            static function (array $baseCustomFee, $key) use ($address, &$customFees) {
                $address->setBaseTotalAmount($baseCustomFee['code'], $baseCustomFee['value']);

                $customFees[$key]['base_value'] = (float)$baseCustomFee['value'];
            }
        );
        array_walk(
            $localCustomFees,
            static function (array $localCustomFee, $key) use ($address, &$customFees) {
                $address->setTotalAmount($localCustomFee['code'], $localCustomFee['value']);

                $customFees[$key]['value'] = (float)$localCustomFee['value'];
            }
        );

        $quote->setData('custom_fees', serialize($customFees));

        return $this;
    }

    /**
     * Fetch custom fees totals
     */
    public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
        parent::fetch($address);

        $quote = $address->getQuote();

        if ($quote === null) {
            Mage::log(
                Mage::helper('custom_fees')
                    ->__(
                        'Could not fetch custom fees for address with ID "%s" because it does not have an associated '
                        . 'quote.',
                        $address->getId()
                    ),
                Zend_Log::CRIT
            );

            return $this;
        }

        // Fix totals being added to order twice
        if (!$quote->isVirtual() && $address->getAddressType() === 'billing') {
            return $this;
        }

        list(, $localCustomFees) = $this->getCustomFees($quote->getStore());

        array_walk(
            $localCustomFees,
            function (array $localCustomFee) use ($address) {
                if ($this->_code !== self::CODE && $localCustomFee['code'] !== $this->_code) {
                    return;
                }

                $address->addTotal($localCustomFee);
            }
        );

        return $this;
    }

    private function getCustomFees(Mage_Core_Model_Store $store)
    {
        $customFees = Mage::getModel('custom_fees/config')->getCustomFees($store->getId());
        $baseCustomFees = array_map(
            static function (array $customFee) {
                $customFee['title'] = Mage::helper('custom_fees')->__($customFee['title']);

                return $customFee;
            },
            $customFees
        );
        $localCustomFees = array_map(
            static function (array $customFee) use ($store) {
                $customFee['value'] = $store->roundPrice($store->convertPrice($customFee['value']));

                return $customFee;
            },
            $baseCustomFees
        );

        return [
            $baseCustomFees,
            $localCustomFees
        ];
    }
}
