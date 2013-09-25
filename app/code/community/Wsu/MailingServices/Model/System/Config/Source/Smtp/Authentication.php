<?php
/**
 * @author Jeremy Bass (jeremyBass)
 * @copyright  Copyright (c) 2013 Jeremy Bass
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Wsu_MailingServices_Model_System_Config_Source_Smtp_Authentication
{
	
	    public function toOptionArray()
    {
    	// There are 4 possibilities: PLAIN, LOGIN and CRAM-MD5, no authentication
    	// http://framework.zend.com/manual/en/zend.mail.smtp-authentication.html
        return array(
        	"none"   => Mage::helper('adminhtml')->__('None (ignore username/password)'),
            "login"   => Mage::helper('adminhtml')->__('Login'),
            "plain"   => Mage::helper('adminhtml')->__('Plain'),
            "crammd5"   => Mage::helper('adminhtml')->__('CRAM-MD5')
        );
    }
}