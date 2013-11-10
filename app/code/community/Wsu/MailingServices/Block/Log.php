<?php


class Wsu_MailingServices_Block_Log extends Mage_Adminhtml_Block_Widget_Grid_Container {
	
    /**
     * Block constructor
     */
    public function __construct() {
    	$this->_blockGroup = 'mailingservices';
        $this->_controller = 'log';
        $this->_headerText = Mage::helper('cms')->__('Email Log');
        parent::__construct();
        
        // Remove the add button
        $this->_removeButton('add');
    }

}
