<?php

class Wsu_Mailingservices_Model_Mail_Type_Sales_CreditmemoEmail extends Wsu_Mailingservices_Model_Mail_Type_Sales_Abstract {
    const TYPE_NEW = 'test_sales_order_creditmemo_email_template';
    const TYPE_UPDATE = 'test_sales_order_creditmemo_update_email_template';
    // Also works with guest template
    
    /**
     * @param Varien_Event_Observer $observer
     * @return Wsu_Mailingservices_Model_Mail_Type_Sales_NewCreditmemoEmail
     */
    public function mailingservicesEmailpreviewRenderEmailBefore(Varien_Event_Observer $observer) {
        if ($observer->getEvent()->getData('templateType') !== self::TYPE_NEW &&
                $observer->getEvent()->getData('templateType') !== self::TYPE_UPDATE) {
            return $this;
        }
        
        $this->_prepareParams($observer, 'sales/order_creditmemo', 'creditmemo');
        
        return $this;
    }
}