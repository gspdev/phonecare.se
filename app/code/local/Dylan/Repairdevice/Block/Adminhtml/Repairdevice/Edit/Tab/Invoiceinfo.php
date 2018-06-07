<?php
class Dylan_Repairdevice_Block_Adminhtml_Repairdevice_Edit_Tab_Invoiceinfo extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();

        $this->setId('webGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        //$this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('repairdevice/repairdeviceinvoice')
            ->getCollection()
            ->addAttributeToFilter('repairdevice_id' , $this->getRequest()->getParam('id'));

        $this->setCollection($collection);
       //print_r($collection);exit;
        return parent::_prepareCollection();
    }

    public function _prepareColumns()
    {
	  
        $this->addColumn('id' , array(
            'header'	=> 'Id',
			'align'     => 'left',
            'width'     => '100px',
            'index'     => 'id',
            'type'  => 'number',
            'sortable' => true,
        ));
		
	    $this->addColumn('payment' , array(
            'header'	=> 'Payment',
            'type'      => 'content',
			//'renderer'  => 'repairdevice/adminhtml_repairdevice_renderer_productname',
			'index'     => 'payment',
			'type'  => 'content',
			'sortable' => true,
        ));
		
		$this->addColumn('shipping' , array(
            'header'	=> 'Shipping',
            'type'      => 'content',
			//'renderer'  => 'repairdevice/adminhtml_repairdevice_renderer_productname',
			'index'     => 'shipping',
			'sortable' => true,
        
		));
		
		$this->addColumn('shipping_cost' , array(
            'header'	=> 'Shipping Cost',
            'type'      => 'content',
			//'renderer'  => 'repairdevice/adminhtml_repairdevice_renderer_productname',
			'index'     => 'shipping_cost',
			'sortable' => true,
        ));
		
		
		$this->addColumn('subtotal' , array(
            'header'	=> 'Subtotal',
            'type'      => 'content',
			//'renderer'  => 'repairdevice/adminhtml_repairdevice_renderer_productname',
			'index'     => 'subtotal',
			'sortable' => true,
        ));
		
		$this->addColumn('grandtotal' , array(
            'header'	=> 'GrandTotal',
            'type'      => 'content',
			//'renderer'  => 'repairdevice/adminhtml_repairdevice_renderer_productname',
			'index'     => 'grandtotal',
			'sortable' => true,
        ));
		
		$this->addColumn('comment' , array(
            'header'	=> 'Comment',
            'type'      => 'content',
			//'renderer'  => 'repairdevice/adminhtml_repairdevice_renderer_productname',
			'index'     => 'comment',
			'sortable' => true,
        ));
		
		
		$this->addColumn('create_t', array(
            'header'    => 'Purchased On',
            'index'     => 'create_at',
            'type'      => 'datetime',
			'sortable' => true,
        ));
		

        return parent::_prepareColumns();
    }
}