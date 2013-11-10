<?php
class Wsu_MailingServices_Model_ReviewReminderEmailTemplate extends Mage_Core_Model_Config_Data {
    protected function _beforeSave() {
        $config_all_fields_value = $this->getFieldset_data();
        if ($config_all_fields_value['enabled'] == 1) {
            $template = $this->getValue();
            if (empty($template) || $template == 'mailingservices_reviewreminder_email_template') {
                throw new Exception('Default template from locale should not be used');
            }
            return $this;
        }
    }
}