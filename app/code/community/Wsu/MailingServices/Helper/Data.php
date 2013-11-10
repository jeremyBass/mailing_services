<?php
class Wsu_MailingServices_Helper_Data extends Mage_Core_Helper_Abstract {
    public function isEnabled() {
        return Mage::getStoreConfig('system/mailingservices/option') != "disabled";
    }
    public function isLogEnabled() {
        return Mage::getStoreConfig('system/mailingservices/logenabled');
    }
    public function isReplyToStoreEmail() {
        return Mage::getStoreConfig('system/mailingservices/store_addresses');
    }
    public function getDevelopmentMode() {
        return Mage::getStoreConfig('system/mailingservices/development');
    }
    public function getGoogleApps() {
        return Mage::getStoreConfig('system/mailingservices/option') == "google";
    }
    public function getSES() {
        return Mage::getStoreConfig('system/mailingservices/option') == "ses";
    }
    public function getSMTP() {
        return Mage::getStoreConfig('system/mailingservices/option') == "smtp";
    }
    // Keeping this function for backward compatibility 
    // It will be dropped eventually so call getTransport() from now on!
    public function getMailingServicesTransport($id = null) {
        return $this->getTransport($id);
    }
    // Keeping this function for backward compatibility 
    // It will be dropped eventually so call getTransport() from now on!
    public function getGoogleAppsEmailTransport($id = null) {
        return $this->getTransport($id);
    }
    public function getTransport($id = null) {
        if ($this->getSMTP()) {
            $username = Mage::getStoreConfig('system/smtpsettings/username', $id);
            $password = Mage::getStoreConfig('system/smtpsettings/password', $id);
            $host     = Mage::getStoreConfig('system/smtpsettings/host', $id);
            $port     = Mage::getStoreConfig('system/smtpsettings/port', $id);
            $ssl      = Mage::getStoreConfig('system/smtpsettings/ssl', $id);
            $auth     = Mage::getStoreConfig('system/smtpsettings/authentication', $id);
            Mage::log('Preparing the SMTP Email transport, details are: \n ' . "  username=" . $username . "\n" . "  password=" . "MASKED" /*. $password  */ . "\n" . "  host=" . $host . "\n" . "  port=" . $port . "\n" . "  ssl=" . $ssl . "\n" . "  auth=" . $auth . "\n");
            // Set up the config array
            $config = array();
            if ($auth != "none") {
                $config['auth']     = $auth;
                $config['username'] = $username;
                $config['password'] = $password;
            }
            if ($port) {
                $config['port'] = $port;
            }
            if ($ssl != "none") {
                $config['ssl'] = $ssl;
            }
            $transport = new Zend_Mail_Transport_Smtp($host, $config);
        } else if ($this->getGoogleApps()) {
            $email = explode(",", Mage::getStoreConfig('system/googlesettings/email', $id));
            // We now allow a load balance of multiple gmail 
            // accounts to get past the 500/day limit.
            if (count($email)) {
                $email = $email[array_rand($email)];
            } else {
                Mage::log("No email configured - 
					you need to specify one in the magento configuration, 
					otherwise your connection will fail");
            }
            $password = Mage::getStoreConfig('system/googlesettings/gpassword', $id);
            Mage::log('Preparing the Google Apps/Gmail Email transport, email to send with is: ' . $email);
            $config    = array(
                'ssl' => 'tls',
                'port' => 587,
                'auth' => 'login',
                'username' => $email,
                'password' => $password
            );
            $transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);
        } else {
            Mage::log("Disabled, or no matching transport");
            return null;
        }
        Mage::log("Returning transport");
        return $transport;
    }
    public function log($to, $template, $subject, $email, $isHtml) {
        $log = Mage::getModel('mailingservices/email_log')->setTo($to)->setTemplate($template)->setSubject($subject)->setEmailBody($isHtml ? $email : nl2br($email))->save();
        return $this;
    }
}
