<?php

class JosephLeedy_CustomFees_Block_System_Config_Form_Field_CustomFees
    extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{
    protected function _prepareToRender()
    {
        $store = $this->getStore();
        $baseCurrency = $store !== null ? $store->getBaseCurrency()->getCurrencyCode() : '';
        $valueColumnLabel = Mage::helper('custom_fees')->__('Fee Amount');

        if ($baseCurrency !== '') {
            $valueColumnLabel .= ' (' . $baseCurrency . ')';
        }

        $this->addColumn(
            'code',
            [
                'label' => Mage::helper('custom_fees')->__('Code'),
                'class' => 'required-entry validate-code'
            ]
        );
        $this->addColumn(
            'title',
            [
                'label' => Mage::helper('custom_fees')->__('Fee Name'),
                'class' => 'required-entry'
            ]
        );
        $this->addColumn(
            'value',
            [
                'label' => $valueColumnLabel,
                'class' => 'required-entry validate-number validate-zero-or-greater'
            ]
        );

        $this->_addAfter = false;
        $this->_addButtonLabel = Mage::helper('custom_fees')->__('Add Custom Fee');
    }

    /**
     * @return Mage_Core_Model_Store|null
     */
    private function getStore()
    {
        /** @var string $storeCode */
        $storeCode = $this->getRequest()->getParam('store');

        if ($storeCode !== null) {
            try {
                $store = Mage::app()->getStore($storeCode);
            } catch (Mage_Core_Model_Store_Exception $storeException) {
                $store = null;
            }
        } else {
            /** @var string $websiteCode */
            $websiteCode = $this->getRequest()->getParam('website');

            try {
                $store = Mage::app()->getWebsite($websiteCode)->getDefaultStore();
            } catch (Mage_Core_Exception $coreException) {
                $store = null;
            }
        }

        return $store;
    }
}