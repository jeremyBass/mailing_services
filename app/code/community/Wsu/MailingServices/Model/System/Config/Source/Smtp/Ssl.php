<?php
/**
 * @author Jeremy Bass (jeremyBass)
 * @copyright  Copyright (c) 2013 Jeremy Bass
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Wsu_MailingServices_Model_System_Config_Source_Smtp_Ssl
{
    public function toOptionArray()
    {
    	// tls, ssl or no security
    	// http://framework.zend.com/manual/en/zend.mail.smtp-secure.html
    	
        return array(
        	"none"   => Mage::helper('adminhtml')->__('No SSL'),
            "ssl"   => Mage::helper('adminhtml')->__('SSL'),
            "tls"   => Mage::helper('adminhtml')->__('SSL TLS'),
        );
    }
}