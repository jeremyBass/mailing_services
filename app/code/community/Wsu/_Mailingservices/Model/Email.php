<?php
class Wsu_Mailingservices_Model_Email extends Mage_Core_Model_Email {
    public function send() {
        // If it's not enabled, just return the parent result.
        if (!Mage::helper('wsu_mailingservices')->isEnabled()) {
            return parent::send();
        }
        Mage::log('Mailingservices is enabled, sending email in Wsu_Mailingservices_Model_Email');
        // The remainder of this function closely mirrors the parent
        // method except for providing the SMTP auth details from the
        // configuration. This is not good OO, but the parent class
        // leaves little room for useful subclassing.
        if (Mage::getStoreConfigFlag('system/smtp/disable')) {
            return $this;
        }
        $mail = new Zend_Mail();
        if (strtolower($this->getType()) == 'html') {
            $mail->setBodyHtml($this->getBody());
        } else {
            $mail->setBodyText($this->getBody());
        }
        $transport = Mage::helper('wsu_mailingservices')->getTransport();
        $dev       = Mage::helper('wsu_mailingservices')->getDevelopmentMode();
        if ($dev == "contact") {
            $email = Mage::getStoreConfig('contacts/email/recipient_email');
            Mage::log("Development mode set to send all emails to contact form recipient: " . $email);
        } elseif ($dev == "supress") {
            Mage::log("Development mode set to supress all emails.");
            # we bail out, but report success
            return $this;
        } else {
            // We just set the outgoing email as normal
            $email = $this->getToEmail();
        }
        $mail->setFrom($this->getFromEmail(), $this->getFromName())->addTo($email, $this->getToName())->setSubject($this->getSubject());
        // If we are using store emails as reply-to's set the header
        if (Mage::helper('wsu_mailingservices')->isReplyToStoreEmail()) {
            // Later versions of Zend have a method for this, and disallow direct header setting...
            if (method_exists($mail, "setReplyTo")) {
                $mail->setReplyTo($this->getSenderEmail(), $this->getSenderName());
            } else {
                $mail->addHeader('Reply-To', $this->getSenderEmail());
            }
            Mage::log('ReplyToStoreEmail is enabled, just set Reply-To header: ' . $this->getSenderEmail());
        }
        Mage::log('About to send email');
        $mail->send($transport);
        Mage::log('Finished sending email');
        $body = $this->getBody();
        Mage::dispatchEvent('mailingservices_email_after_send', array(
            'to' => $this->getToName(),
            'subject' => $this->getSubject(),
            'template' => "n/a", //TODO: is that true?
            'html' => (strtolower($this->getType()) == 'html'),
            'email_body' => $body
        ));
        return $this;
    }
}
