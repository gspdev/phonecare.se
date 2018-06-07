<?php
class Dylan_Repairdevice_Block_Adminhtml_Repairdevice_Edit_Tab_Address extends Mage_Adminhtml_Block_Widget_Grid
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
        $collection = Mage::getModel('repairdevice/repairaddress')
            ->getCollection()
            ->addAttributeToFilter('repair_id' , $this->getRequest()->getParam('id'));

        $this->setCollection($collection);
       //print_r($collection);exit;
        return parent::_prepareCollection();
    }

    public function _prepareColumns()
    {
	  $type_address = Dylan_Repairdevice_Model_Shipping_Shippingmethod::getShippingType();
       $this->addColumn("type_address" ,
            array(
                "header"    => Mage::helper('repairdevice')->__('Shipping Method'),
                "align"     => "left",
                "width"     => "50px",
                "type"      => "options",
                'index'     => "type_address",
                "options"   => $type_address
            )
        );
		
        $this->addColumn('firstname' , array(
            'header'	=> 'firstname',
			'align'     => 'left',
            'width'     => '100px',
            'index'     => 'firstname',
            'type'  => 'content',
            'sortable' => true,
        ));
		
	    $this->addColumn('lastname' , array(
            'header'	=> 'lastname',
            'type'      => 'content',
			//'renderer'  => 'repairdevice/adminhtml_repairdevice_renderer_productname',
			'index'     => 'lastname',
			'sortable' => true,
        ));
		
		$this->addColumn('company' , array(
            'header'	=> 'company',
            'type'      => 'content',
			//'renderer'  => 'repairdevice/adminhtml_repairdevice_renderer_productname',
			'index'     => 'company',
			'sortable' => true,
        ));
		$this->addColumn('city' , array(
            'header'	=> 'City',
            'type'      => 'content',
			//'renderer'  => 'repairdevice/adminhtml_repairdevice_renderer_productname',
			'index'     => 'city',
			'sortable' => true,
        ));
		$this->addColumn('street' , array(
            'header'	=> 'street',
            'type'      => 'content',
			//'renderer'  => 'repairdevice/adminhtml_repairdevice_renderer_productname',
			'index'     => 'street',
			'sortable' => true,
        ));
		
		$this->addColumn('vat_id' , array(
            'header'	=> 'Vat',
            'type'      => 'content',
			//'renderer'  => 'repairdevice/adminhtml_repairdevice_renderer_productname',
			'index'     => 'vat_id',
			'sortable' => true,
        ));
		
		$this->addColumn('region' , array(
            'header'	=> 'region',
            'type'      => 'content',
			//'renderer'  => 'repairdevice/adminhtml_repairdevice_renderer_productname',
			'index'     => 'region',
			'sortable' => true,
        ));
		
		$this->addColumn('postcode' , array(
            'header'	=> 'postcode',
            'type'      => 'content',
			//'renderer'  => 'repairdevice/adminhtml_repairdevice_renderer_productname',
			'index'     => 'postcode',
			'sortable' => true,
        ));
		
		$this->addColumn('telephone' , array(
            'header'	=> 'telephone',
            'type'      => 'content',
			//'renderer'  => 'repairdevice/adminhtml_repairdevice_renderer_productname',
			'index'     => 'telephone',
			'sortable' => true,
        ));
		
		$this->addColumn('fax' , array(
            'header'	=> 'fax',
            'type'      => 'content',
			//'renderer'  => 'repairdevice/adminhtml_repairdevice_renderer_productname',
			'index'     => 'fax',
			'sortable' => true,
        ));
		
		

        return parent::_prepareColumns();
    }
}