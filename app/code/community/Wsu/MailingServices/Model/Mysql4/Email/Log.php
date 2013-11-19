<?php
class Wsu_MailingServices_Model_Mysql4_Email_Log extends Mage_Core_Model_Mysql4_Abstract {
    protected function _construct() {
        $this->_init('mailingservices/email_log', 'email_id');
    }
}