<?php
class Wsu_Mailingservices_IndexController extends Mage_Adminhtml_Controller_Action {
    public static $CONTACTFORM_SENT;
    public function indexAction() {
        Mage::log("Running Mailing Services Self Test");
        #report development mode for debugging
        $dev = Mage::helper('wsu_mailingservices')->getDevelopmentMode();
        Mage::log("Development mode: " . $dev);
        $success      = true;
        $websiteModel = Mage::app()->getWebsite($this->getRequest()->getParam('website'));
        $msg          = "WSU Mailing Services Self-test results";
        $msg          = $msg . "<br/>Testing outbound connectivity to Server:";
        Mage::log("Raw connection test....");
        $googleapps  = Mage::helper('wsu_mailingservices')->getGoogleApps();
        $smtpEnabled = Mage::helper('wsu_mailingservices')->getSMTP();
        $sesEnabled  = Mage::helper('wsu_mailingservices')->getSES();
        if ($googleapps) {
            $msg  = $msg . "<br/>Using Google Apps/Gmail configuration options";
            $host = "smtp.gmail.com";
            $port = 587;
        } else if ($smtpEnabled) {
            $msg  = $msg . "<br/>Using SMTP configuration options";
            $host = Mage::getStoreConfig('system/smtpsettings/host', $websiteModel->getId());
            $port = Mage::getStoreConfig('system/smtpsettings/port', $websiteModel->getId());
        } else {
            $msg = $msg . "<br/> extension disabled, cannot test outbound connectivity";
            Mage::log("skipped, disabled.");
        }
        if ($googleapps || $smtpEnabled) {
            $fp = false;
            try {
                $fp = fsockopen($host, $port, $errno, $errstr, 15);
            }
            catch (Exception $e) {
                // An error will be reported below.
            }
            Mage::log("Complete");
            if (!$fp) {
                $success = false;
                $msg     = $msg . "<br/>Failed to connect to SMTP server. Reason: " . $errstr . "(" . $errno . ")";
                $msg     = $msg . "<br/> This extension requires an outbound SMTP connection on port: " . $port;
            } else {
                $msg = $msg . "<br/> Connection to Host SMTP server successful.";
                fclose($fp);
            }
        }
        $to   = Mage::getStoreConfig('contacts/email/recipient_email', $websiteModel->getId());
		if(Mage::helper('wsu_mailingservices')->isReplyToStoreEmail()){
			$from = Mage::getStoreConfig('contacts/email/sender_email_identity', $websiteModel->getId());
		}else{
			$from = Mage::getStoreConfig('system/mailingservices/from_address', $websiteModel->getId());
		}
        $mail = new Zend_Mail();
        $sub  = "Test Email From WSU Mailing Services Module";
        $body = "Hi,\n\n" .
				 "If you are seeing this email then your SMTP settings are correct! \n\n" .
				 "For more information about this extension and tips for using it please visit wsu.edu.\n\n" .
				 "Cheers,\nJeremy Bass";
        $mail->addTo($to)->setFrom($from)
            ->setSubject($sub)->setBodyText($body);
        if ($dev != "supress") {
            Mage::log("Actual email sending test....");
            $msg = $msg . "<br/> Sending test email to your contact form address " . $to . ":";
            try {
                $transport = Mage::helper('wsu_mailingservices')->getTransport($websiteModel->getId());
                $mail->send($transport);
                Mage::dispatchEvent('mailingservices_email_after_send', array(
                    'to' => $to,
                    'template' => "Mailingservices Self Test",
                    'subject' => $sub,
                    'html' => false,
                    'email_body' => $body
                ));
                $msg = $msg . "<br/> Test email was sent successfully.";
                Mage::log("Test email was sent successfully");
            }
            catch (Exception $e) {
                $success = false;
                $msg     = $msg . "<br/> Unable to send test email. Exception message was: " . $e->getMessage() . "...";
                $msg     = $msg . "<br/> Please check and double check your username and password.";
                Mage::log("Test email was not sent successfully: " . $e->getMessage());
            }
        } else {
            Mage::log("Not sending test email - all mails currently supressed");
            $msg = $msg . "<br/> No test email sent, development mode is set to supress all emails.";
        }
        // Now we test that the actual core overrides are occuring as expected.
        // We trigger the contact form email, as though a user had done so.
        Mage::log("Actual contact form submit test...");
        self::$CONTACTFORM_SENT = false;
        $this->_sendTestContactFormEmail();
        // If everything worked as expected, the observer will have set this value to true.
        if (self::$CONTACTFORM_SENT) {
            $msg = $msg . "<br/> Contact Form test email used Mailingservices to send correctly.";
        } else {
            $success = false;
            $msg     = $msg . "<br/> Contact Form test email did not use Mailingservices to send.";
        }
        Mage::log("Complete");
        if ($success) {
            $msg = $msg . "<br/> Testing complete, if you are still experiencing difficulties please visit  <a target='_blank' href='http://wsu.edu'>wsu.edu</a> to contact me.";
            Mage::getSingleton('adminhtml/session')->addSuccess($msg);
        } else {
            $msg = $msg . "<br/> Testing failed,  please review the reported problems and if you need further help visit  <a target='_blank' href='http://wsu.edu'>wsu.edu</a> to contact me.";
            Mage::getSingleton('adminhtml/session')->addError($msg);
        }
        $this->_redirectReferer();
    }
    private function _sendTestContactFormEmail() {
        $postObject = new Varien_Object();
        $postObject->setName("Mailingservices Tester");
        $postObject->setComment("If you get this email then everything seems to be in order.");
        $postObject->setEmail("jeremy.bass@wsu.edu"); //@todo abstract this
        $mailTemplate = Mage::getModel('core/email_template');
        /* @var $mailTemplate Mage_Core_Model_Email_Template */
        include Mage::getBaseDir() . '/app/code/core/Mage/Contacts/controllers/IndexController.php';
        $mailTemplate->setDesignConfig(array(
            'area' => 'frontend'
        ))->setReplyTo($postObject->getEmail())->sendTransactional(Mage::getStoreConfig(Mage_Contacts_IndexController::XML_PATH_EMAIL_TEMPLATE), Mage::getStoreConfig(Mage_Contacts_IndexController::XML_PATH_EMAIL_SENDER), Mage::getStoreConfig(Mage_Contacts_IndexController::XML_PATH_EMAIL_RECIPIENT), null, array(
            'data' => $postObject
        ));
    }
}
