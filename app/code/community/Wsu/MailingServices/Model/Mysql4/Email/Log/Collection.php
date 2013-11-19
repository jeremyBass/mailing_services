<?php
class Wsu_MailingServices_Model_Mysql4_Email_Log_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {
    protected function _construct() {
        $this->_init('mailingservices/email_log');
    }
}