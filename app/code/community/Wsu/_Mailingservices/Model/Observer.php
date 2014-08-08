<?php
class Wsu_Mailingservices_Model_Observer {
    public function log($observer) {
        $event = $observer->getEvent();
        if (Mage::helper('wsu_mailingservices')->isLogEnabled()) {
            Mage::helper('wsu_mailingservices')->log($event->getTo(), $event->getTemplate(), $event->getSubject(), $event->getEmailBody(), $event->getHtml());
        }
        // For the self test, if we're sending the contact form notify the self test class
        //Mage::log("template=" . $event->getTemplate());
        if ($event->getTemplate() == "contacts_email_email_template") {
            include_once Mage::getBaseDir() . "/app/code/community/Wsu/Mailingservices/controllers/IndexController.php";
            Wsu_Mailingservices_IndexController::$CONTACTFORM_SENT = true;
        }
    }
}
