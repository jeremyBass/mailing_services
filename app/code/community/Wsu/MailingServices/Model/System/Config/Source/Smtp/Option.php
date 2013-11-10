<?php


class Wsu_MailingServices_Model_System_Config_Source_Smtp_Option
{
	
	    public function toOptionArray()
    {
        return array(
        	"disabled"   => Mage::helper('adminhtml')->__('Disabled'),
            "google"   => Mage::helper('adminhtml')->__('Google Apps/Gmail'),
            "smtp"   => Mage::helper('adminhtml')->__('SMTP'),
           //"ses"   => Mage::helper('adminhtml')->__('SES (experimental)')
        );
    }
}