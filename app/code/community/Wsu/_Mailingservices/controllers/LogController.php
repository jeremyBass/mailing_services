<?php
class Wsu_Mailingservices_LogController extends Mage_Adminhtml_Controller_Action {
    protected function _initAction() {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()->_setActiveMenu('system/tools')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('System'), Mage::helper('adminhtml')->__('System'))
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Tools'), Mage::helper('adminhtml')->__('Tools'))
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Email Log'), Mage::helper('adminhtml')->__('Email Log'));
        return $this;
    }
    public function indexAction() {
        $this->_initAction()->_addContent($this->getLayout()->createBlock('wsu_mailingservices/log'))->renderLayout();
    }
    public function viewAction() {
        $this->_initAction()->_addContent($this->getLayout()->createBlock('wsu_mailingservices/log_view'))->renderLayout();
    }
}
