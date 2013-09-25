<?php
/**
 *
 * @author Jeremy Bass (jeremyBass)
 * @copyright  Copyright (c) 2013 Jeremy Bass
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Wsu_MailingServices_Model_Mysql4_Email_Log_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {
	
    protected function _construct() {
        $this->_init('mailingservices/email_log');
    }
}