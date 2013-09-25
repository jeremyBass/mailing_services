<?php
/**
 * Observer that logs emails after they have been sent
 * @author Jeremy Bass (jeremyBass)
 * @copyright  Copyright (c) 2013 Jeremy Bass
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Wsu_MailingServices_Model_Observer {
	
	public function log($observer) {
		
		$event = $observer->getEvent();
		if (Mage::helper('mailingservices')->isLogEnabled()) {
			
				Mage::helper('mailingservices')->log(
				$event->getTo(),
				$event->getTemplate(),
				$event->getSubject(),
				$event->getEmailBody(),
				$event->getHtml());
		}
		
		// For the self test, if we're sending the contact form notify the self test class
		Mage::log("template=" . $event->getTemplate());
		if($event->getTemplate() == "contacts_email_email_template") {
			include_once Mage::getBaseDir() . "/app/code/community/Wsu/MailingServices/controllers/IndexController.php";
			Wsu_MailingServices_IndexController::$CONTACTFORM_SENT = true;
		}
		
	}
	
}
