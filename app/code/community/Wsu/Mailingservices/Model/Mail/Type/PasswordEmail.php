<?php
class Wsu_Mailingservices_Model_Mail_Type_PasswordEmail {
    const TYPE_FORGOT_PASSWORD = 'test_forgot_password_email_template';
    const TYPE_REMIND_PASSWORD = 'test_remind_password_email_template';
    
    /**
     * @param Varien_Event_Observer $observer
     * @return Wsu_Mailingservices_Model_Mail_Type_OrderEmail
     */
    public function mailingservicesEmailpreviewRenderEmailBefore(Varien_Event_Observer $observer) {
        if (!in_array($observer->getEvent()->getData('templateType'), array(self::TYPE_FORGOT_PASSWORD, self::TYPE_REMIND_PASSWORD))) {
            return $this;
        }
        
        $templateParams = $observer->getEvent()->getData('templateParams');
        $requestParams = $templateParams->getRequestParams();
        $customerId = $requestParams['customerId'];
        $customer = Mage::getModel('customer/customer')->load($customerId);
        $customer->setPassword(Mage::helper('wsu_mailingservices')->__('[yourpasswordhere]'));
        $templateParams->setCustomer($customer);

        return $this;
    }
}
