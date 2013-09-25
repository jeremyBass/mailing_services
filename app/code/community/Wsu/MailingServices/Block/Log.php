<?php
/** * @author Jeremy Bass (jeremyBass)
 * @copyright  Copyright (c) 2013 Jeremy Bass
* @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

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
