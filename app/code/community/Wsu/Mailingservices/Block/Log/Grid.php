<?php
class Wsu_Mailingservices_Block_Log_Grid extends Mage_Adminhtml_Block_Widget_Grid {
    public function __construct() {
        parent::__construct();
        $this->setId('emailLogGrid');
        $this->setDefaultSort('email_id');
        $this->setDefaultDir('ASC');
    }
    protected function _prepareCollection() {
        $collection = Mage::getModel('wsu_mailingservices/log')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    protected function _prepareColumns() {
        $baseUrl = $this->getUrl();
        $this->addColumn('email_id', array(
            'header' => Mage::helper('adminhtml')->__('Id'),
            'width' => '30px',
            'index' => 'email_id'
        ));
        $this->addColumn('sent', array(
            'header' => Mage::helper('adminhtml')->__('Sent'),
            'width' => '60px',
            'index' => 'log_at'
        ));
        $this->addColumn('subject', array(
            'header' => Mage::helper('adminhtml')->__('Subject'),
            'width' => '160px',
            'index' => 'subject'
        ));
        $this->addColumn('to', array(
            'header' => Mage::helper('adminhtml')->__('To'),
            'width' => '160px',
            'index' => 'to'
        ));
        return parent::_prepareColumns();
    }

    public function getRowUrl($row) {
        return $this->getUrl('*/*/view', array(
            'email_id' => $row->getId()
        ));
    }
}
