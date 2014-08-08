<?php
class Wsu_Mailingservices_Model_Resource_Log extends Mage_Core_Model_Resource_Db_Abstract {
    protected function _construct() {
        $this->_init('wsu_mailingservices/log', 'email_id');
    }
}