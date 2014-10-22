<?php
class Wsu_Mailingservices_Model_Mail_Type_SitemapGenerateWarningsEmail {
    const TYPE = 'test_sitemap_generate_warnings_email_template';
    
    /**
     * @param Varien_Event_Observer $observer
     * @return Wsu_Mailingservices_Model_Mail_Type_OrderEmail
     */
    public function mailingservicesEmailpreviewRenderEmailBefore(Varien_Event_Observer $observer) {
        if ($observer->getEvent()->getData('templateType') !== self::TYPE) {
            return $this;
        }
        
        $templateParams = $observer->getEvent()->getData('templateParams');
        $templateParams->setWarnings(Mage::helper('wsu_mailingservices')->__('[error 1]') . "\n" . Mage::helper('wsu_mailingservices')->__('[error 2]'));
        
        return $this;
    }
}
