<?php
class Wsu_Mailingservices_Model_Mail_Type_TokenStatusChangeEmail {
    const TYPE = 'test_token_status_change_email_template';
    
    /**
     * @param Varien_Event_Observer $observer
     * @return Wsu_Mailingservices_Model_Mail_Type_OrderEmail
     */
    public function mailingservicesEmailpreviewRenderEmailBefore(Varien_Event_Observer $observer)  {
        if ($observer->getEvent()->getData('templateType') !== self::TYPE) {
            return $this;
        }
        
        $templateParams = $observer->getEvent()->getData('templateParams');
        $templateParams->setName(Mage::helper('wsu_mailingservices')->__('[yourname]'));
        $templateParams->setData('userName', Mage::helper('wsu_mailingservices')->__('[yourname]'));
        $templateParams->setEmail(Mage::helper('wsu_mailingservices')->__('[email@example.com]'));
        $templateParams->setData('applicationName', Mage::helper('wsu_mailingservices')->__('[application_name]'));
        $templateParams->setStatus(Mage::helper('wsu_mailingservices')->__('[status]'));
        
        return $this;
    }
}
