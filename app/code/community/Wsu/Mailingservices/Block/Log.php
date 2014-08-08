<?php
class Wsu_Mailingservices_Block_Log extends Mage_Adminhtml_Block_Widget_Grid_Container {
    public function __construct() {
        $this->_blockGroup = 'wsu_mailingservices';
        $this->_controller = 'log';
        $this->_headerText = Mage::helper('cms')->__('Email Log');
        parent::__construct();
        // Remove the add button
        $this->_removeButton('add');
    }
}
