<?php
/**
 * @author Jeremy Bass (jeremyBass)
 * @copyright  Copyright (c) 2013 Jeremy Bass
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Wsu_MailingServices_Model_System_Config_Source_Smtp_Development
{
	
	    public function toOptionArray()
    {
        return array(
        	"disabled"   => Mage::helper('adminhtml')->__('Development Mode disabled'),
            "contact"   => Mage::helper('adminhtml')->__('Redirect to contact form email'),
            "supress"   => Mage::helper('adminhtml')->__('Supress all emails')
        );
    }
}