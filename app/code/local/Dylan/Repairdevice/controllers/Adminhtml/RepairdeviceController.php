<?php
/**
 * IDEALIAGroup srl
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@idealiagroup.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future.
 *
 * @category   IG
 * @package    IG_LightBox
 * @copyright  Copyright (c) 2010-2011 IDEALIAGroup srl (http://www.idealiagroup.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author     Riccardo Tempesta <tempesta@idealiagroup.com>
*/
 
class  Dylan_Repairdevice_Adminhtml_RepairdeviceController extends Mage_Adminhtml_Controller_action
{
	protected function _initAction()
    {
        $this->loadLayout()->_setActiveMenu('repairdevice/repairdevice')
                           ->_addBreadcrumb(
                      Mage::helper('adminhtml')->__('Repairdevice Manager'),            
                      Mage::helper('adminhtml')->__('Repairdevice Manager')
                         );
        return $this;
    }
	public function indexAction()
    {
        $this->_initAction()->renderLayout();
    }
	
	public function newAction()
    {
        $this->_forward('edit');
    }
	
	 public function editAction()
    {
        $id    = $this->getRequest()->getParam('id');
        $model = Mage::getModel('repairdevice/repairdevice')->load($id);
        if ($model->getRepairdeviceId() || $id == 0) {
           $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
           if (!empty($data)) {
               $model->setData($data);
           }
           Mage::register('repairdevice_data', $model);
           $this->loadLayout();
           $this->_setActiveMenu('repairdevice/repairdevice');
           $this->_addBreadcrumb(
                          Mage::helper('adminhtml')->__('Repairdevice Manager'),         
                          Mage::helper('adminhtml')->__('Repairdevice Manager')
           );
           $this->_addBreadcrumb(
                          Mage::helper('adminhtml')->__('Repairdevice News'),    
                          Mage::helper('adminhtml')->__('Repairdevice News')
           );
           $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
           $this->_addContent(
           		$this->getLayout()->createBlock('repairdevice/adminhtml_repairdevice_edit')
		   )->_addLeft(
		   		$this->getLayout()->createBlock('repairdevice/adminhtml_repairdevice_edit_tabs')
		   );
           $this->renderLayout();
        } else {
           Mage::getSingleton('adminhtml/session')->addError(
                          Mage::helper('repairdevice')->__('Item does not exist')
           );
           $this->_redirect('*/*/');
        }
    }
	
	 public function newInvoiceAction()
    {
         $id    = $this->getRequest()->getParam('id');
		 
		// $data = $this->getRequest()->getPost();
		// print_r($data);exit;
		 
        $model = Mage::getModel('repairdevice/repairdevice')->load($id);
        if ($model->getRepairdeviceId() || $id == 0) {
           $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
		  // print_r($model);exit;
           if (!empty($data)) {
               $model->setData($data);
           }
           Mage::register('repairdevice_data', $model);
           $this->loadLayout();
           $this->_setActiveMenu('repairdevice/repairdevice');
           $this->_addBreadcrumb(
                          Mage::helper('adminhtml')->__('Repairdevice Manager'),         
                          Mage::helper('adminhtml')->__('Repairdevice Manager')
           );
           $this->_addBreadcrumb(
                          Mage::helper('adminhtml')->__('Repairdevice News'),    
                          Mage::helper('adminhtml')->__('Repairdevice News')
           );
           $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
           $this->_addContent(
           		$this->getLayout()->createBlock('repairdevice/adminhtml_invoice')
		   )->_addLeft(
		   		$this->getLayout()->createBlock('repairdevice/adminhtml_invoice')
		   );
           $this->renderLayout();
        } else {
           Mage::getSingleton('adminhtml/session')->addError(
                          Mage::helper('repairdevice')->__('Item does not exist')
           );
           $this->_redirect('*/*/');
        }
    }
	
	public function _getProduct($productIdArray){
		 
		 $data = '';
		 foreach ($productIdArray as $productId){
				  $product = Mage::getModel('catalog/product')->load($productId); 
				  $data[]= '<tr>
																<td align="left" valign="top" style="padding:3px 9px; border-bottom:1px dotted #CCCCCC;">
																	<strong style="font-size:11px;">'.$product->getName().'</strong>
																</td>
																<td align="left" valign="top" style="font-size:11px; padding:3px 9px; border-bottom:1px dotted #CCCCCC;">'.$product->getSku().'</td>
																<td align="center" valign="top" style="font-size:11px; padding:3px 9px; border-bottom:1px dotted #CCCCCC;">1</td>
																<td align="right" valign="top" style="font-size:11px; padding:3px 9px; border-bottom:1px dotted #CCCCCC;"><span class="price">'.Mage::helper('core')->currency($product->getPrice(), true, false).'</span></td>
															</tr>';
			 }
		return implode('',$data); 
	}
	
	
	public function _getShipping($repair_id){
		 
		 
		 $resource = Mage::getSingleton('core/resource');
		 $readConnection = $resource->getConnection('core_read');
		 $tableName = $resource->getTableName('repairdevicedata');
		 $sql = "SELECT * FROM ".$tableName." where repairdevice_id = $repair_id";
		 $res = $readConnection->fetchRow($sql);
		 
		 //load shipping address
		 $tableNameAddress = $resource->getTableName('repair_address');
		 $sqlAddress = "SELECT * FROM ".$tableNameAddress." where repair_id = $repair_id and type_address=1";
		 $resAddress = $readConnection->fetchRow($sqlAddress);
		 
		 $dataShipping ='';
		 if($res['shipping_method']==1){
			 $dataShipping[]=' <p>'.$resAddress['firstname'].' '.$resAddress['lastname'].'<br>
								'.$resAddress['company'].'<br>
								'.$resAddress['street'].'<br>
								'.$resAddress['city'].','.$resAddress['region'].', '.$resAddress['postcode'].'<br>
								'.Mage::getModel('directory/country')->load($resAddress['country_id'])->getName().'<br>
								T: <span style="border-bottom:1px dashed #ccc;z-index:1" t="7" onclick="return false;" data="'.$resAddress['telephone'].'">'.$resAddress['telephone'].'</span>
								<br>F: '.$resAddress['fax'].'
								<br>VAT: '.$resAddress['vat_id'].'</p>';
		 }else if($res['shipping_method']==2){
			  $dataShipping[] = '<p style="margin:0;">'.Mage::helper('repairdevice')->__('Kungsgatan 29, 11156 Stockholm, Sverige').'</p>';
		 }else{
			  $dataShipping[] = '<p style="margin:0;">'.Mage::helper('repairdevice')->__('Tivolivägen 2, 12631 Hägersten, Sverige').'</p>';
		 }

		 return implode('',$dataShipping); 
	}
	
	
	public function saveInvoiceAction()
    {
		
		 $id    = $this->getRequest()->getParam('id');
		 
		 $dataPost = $this->getRequest()->getPost();
		 //print_r($dataPost);exit;
		 $repaire_id = $this->getRequest()->getPost('repairdevice_id');
		 $resource = Mage::getSingleton('core/resource');
		 $readConnection = $resource->getConnection('core_read');
		 $tableName = $resource->getTableName('repairdevicedata');
		 $sql = "SELECT * FROM ".$tableName." where repairdevice_id = $repaire_id";
		 $res = $readConnection->fetchRow($sql);
		 $dataModel['repairdevice_id'] = $res['repairdevice_id'];
		 $dataModel['invoice_id'] = $res['invoice_id'];
		 $dataModel['customer_id'] = $res['customer_id'];
		 // $dataModel['imei'] = $res['imei'];
		 // $dataModel['screencode'] = $res['screencode'];
		 // $dataModel['detailed'] = $res['detailed'];
		 $dataModel['payment'] = $dataPost['payment'];
		 
		 if(isset($dataPost['shipping'])){
			 $dataShppingTitle = $dataPost['shipping'][0];
			 $dataModel['shipping'] = $dataShppingTitle;
		 }
		 if(isset($dataPost['shipping_cost'])){
			 $dataSppingCost =$dataPost['shipping_cost'];
			 $dataModel['shipping_cost'] = $dataSppingCost;
		 }
		 
		 $dataModel['subtotal'] = $dataPost['subTotal'];
		
		 $dataModel['grandtotal'] = $dataPost['grandTotal'];
		 $dataModel['comment'] = $dataPost['comment'];
		 //$dataModel['invoice_status'] = $res['invoice_status'];
		 $dataSentEmail = $dataPost['customer_email'];
		 //$dataModel['create_at'] = $dataPost['create_at'];
		 $todayDate  = Mage::app()->getLocale()->date()->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
		 $dataModel['create_at'] = $todayDate;
		 //print_r($todayDate);exit;
		 $model = Mage::getModel('repairdevice/repairdeviceinvoice')->load($id);
		 //$model->addData($dataModel)->setId($this->getRequest()->getParam('id'));
		 $model->setData($dataModel);
		 if($model->save()){
			 
			 $resource = Mage::getSingleton('core/resource');
			 $inster = Mage::getSingleton('core/resource')->getConnection('core_write');
			 
			  $productIdArray = $this->getRequest()->getPost('invoice_products');
			  if(is_array($productIdArray)){
				   foreach($productIdArray as $productId){
				
						$tableName = $resource->getTableName('repair_product');
						$sql_inster = "INSERT INTO ".$tableName." (repair_id,product_id,if_invoice)VALUES('".$repaire_id."','$productId',1)";
						$inster->query($sql_inster);  
			       }
			  }
			 
			 $tablePrefix = (string) Mage::getConfig()->getTablePrefix();
			 $updateQue = "UPDATE ". $tablePrefix ." repairdevicedata SET invoice_status=3 WHERE repairdevice_id =$repaire_id";
			 $readConnection->query($updateQue);			
 
			 $productIdArray = $this->getRequest()->getPost('invoice_products');				 
											
			//$ff = $this->_getProduct($this->getRequest()->getPost('invoice_products'));
            //print_r($this->_getShipping($repaire_id));exit;			
										 
			
		     $mailSubject = 'Repairdevice Customer Invoice';
			 $from_email = "info@phonecare.se";
			 $from_name = "Repairdevice Customer Invoice";

			$Limit=15*86000;
			$duedate = date("Y-m-d H:i:s" , strtotime($res['create_at']) + $Limit);
            $html='
			  <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#f6f6f6">
    <tbody>
            <tr>
                <td>
                    <table class="outer" width="650" style="" cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff">
                        <!--header-->
                        <tr style="padding: 0 1px;height:100px;">
                            <td valign="top" style="vertical-align: top;padding-top: 20px;">
                            <div style="padding-left:10px">
								<a href="https://www.phonecare.se/" style="display: block;">
									<img src="https://www.phonecare.se/skin/frontend/tv_bigboom_package/tv_bigboom1/images/logo_email.gif" alt="PhoneCare" width="165" style="margin-left:10px;">
								</a>
                              </div>
                                <!--head-left-->

                                <table width="99%" border="0" cellspacing="10" cellpadding="0">
                                  <tr>
                                      <td>
                                      <div style="font-size:12px;padding:0 12px">
                                        <p>Email:info@phonecare.se</p>
                                        <p>Address:</p>
                                      <p><a href="https://www.phonecare.se/">https://www.phonecare.se/</a></p>
                                      </div></td>
                                    </tr>
                              </table>
                                
                            </td>
                            <!--head-right-->
                            <td style="padding-top: 20px;">
                                <table width="99%">
                                    <tr>
                                        <td>
                                          <table width="100%" border="0" cellspacing="1" cellpadding="0">
                                              <tr>
                                                <td>
                                                </td>
                                              </tr>
                                            </table>
                                            <table width="99%">
                                                <tr>
                                                    <td style="vertical-align: top;">
                                                      <div style="font-size: 12px;">
                                                        <p style="margin: 0 0 4px 0;font-weight:bold;">Date</p>
                                                        <p style="margin: 0;">'.$res['create_at'].'</p>
                                                        </div>
                                                      <div style="font-size: 12px;padding-right:20px;">
                                                        <p style="margin: 10px 0 4px 0;font-weight:bold;"> Invoice id</p>
                                                        <p style="margin:0;">'.$res['invoice_id'].'</p>
                                                        </div>
                                                    </td>
                                              </tr>
                                                <tr>
                                                    <td style="vertical-align: top;font-size: 12px;">
                                                        <p style="margin:10px 0 4px 0;font-weight:bold;">Shipping address</p>
                                                        <div style="font-size: 12px;padding:0;margin:0;">
                                                            '.$this->_getShipping($repaire_id).'
                                                        </div>
                                                    </td>
                                                </tr>
                                          </table>
                                      </td>
                                    </tr>
                                </table>
                          </td>
                        </tr>
                        <tr>
                            <td style="height: 10px;"></td>
                        </tr>
                        <tr>
                            <td width="359" style="vertical-align: bottom">
                            </td>
                            <td width="291">
                                <div style="float:right;width: 200px;font-size:14px;">
                                    <p style="margin: 0;padding: 10px 10px;text-align: right;"> Total: <span style="font-weight: bold;">'.Mage::helper('core')->currency($dataPost['grandTotal'], true, false).'</span></p>
                                </div>
                            </td>
                        </tr>
                        <tr style="height: 10px;"></tr>
                        <!--order-->
						<tr>
							<td colspan="2" align="center">
								<table cellspacing="0" cellpadding="0" border="0" width="650" style="border:1px solid #EAEAEA;">
									<thead>
										<tr>
											<th align="left" bgcolor="#EAEAEA" style="font-size:13px; padding:3px 9px">Artikel</th>
											<th align="left" bgcolor="#EAEAEA" style="font-size:13px; padding:3px 9px">Artikelnummer</th>
											<th align="center" bgcolor="#EAEAEA" style="font-size:13px; padding:3px 9px">Antal</th>
											<th align="right" bgcolor="#EAEAEA" style="font-size:13px; padding:3px 9px">Summa (ex.moms)</th>
										</tr>
									</thead>
									
									<tbody>
									
									 '.$this->_getProduct($productIdArray).'
										
									</tbody>
							
									<tfoot>
										<tr class="subtotal">
											<td colspan="3" align="right" style="padding:3px 9px"><p style="margin:0;">Summa (ex.moms)</p></td>
											<td align="right" style="padding:3px 9px"><span class="price">'.Mage::helper('core')->currency($dataPost['subTotal'], true, false).'</span></td>
										</tr>
										<tr class="shipping_cost">
											<td colspan="3" align="right" style="padding:3px 9px"><p style="margin:0;">Shipping Cost</p></td>
											<td align="right" style="padding:3px 9px"><span class="price">'.$dataShppingTitle.'(SEK'.$dataSppingCost.')</td>
										</tr>
										<tr class="grand_total">
											<td colspan="3" align="right" style="padding:3px 9px">
												<strong>Total</strong>
											</td>
											<td align="right" style="padding:3px 9px">
												<strong><span class="price">'.Mage::helper('core')->currency($dataPost['grandTotal'], true, false).'</span></strong>
											</td>
										</tr>
									</tfoot>
								</table>
							</td>
                        </tr>
                    </table>
              </td>
            </tr>
            <tr>
                <td>
                    <table class="outer" width="650" style="" cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff">
                        <!--footer-->
                        <tr>
                            <td width="450" style="vertical-align: top;">
                                <h5 style="text-transform: uppercase;padding: 25px 0 0 10px;">Order info:</h5>
                                <div style="font-size: 12px;padding:0 12px;">
                                    <p>Grand Total: <span style="font-weight: bold;">'.Mage::helper('core')->currency($dataPost['grandTotal'], true, false).'</span></p>
                                    <p>Due Date: '.$duedate.'</p>
                                </div>
                            </td>
                            <td width="450" style="vertical-align: top;">
                                <h5 style="text-transform: uppercase;padding: 25px 0 0 10px;">Payment method:</h5>
                                <div style="font-size: 12px;padding:0 12px;border-left:1px solid #000;">
								'.$dataPost['payment'].'
                                </div>
                            </td>
							 <td width="450" style="vertical-align: top;">
                                <h5 style="text-transform: uppercase;padding: 25px 0 0 10px;">Comments:</h5>
                                <div style="font-size: 12px;padding:0 12px;border-left:1px solid #000;">
								'.$dataPost['comment'].'
                                </div>
                            </td>
                        </tr>
                        <tr>
                          <td colspan="3" align="center" valign="middle" style="vertical-align: top;"><br>Thank you, phonecare.se!</td>
                        </tr>
                    </table>
                </td>
            </tr>
  </tbody>
    </table>
			';
		   
			$mail = Mage::getModel('core/email');
			$mail->setToName('Repairdevice Customer Invoice');
           //print_r($mail->setBody($processedTemplate));exit;
			//$mail->setTemplateParam($email_template_variables);
			$mail->setToEmail($dataSentEmail);
			$mail->setBody($html);
			$mail->setSubject($mailSubject);
			$mail->setFromEmail($from_email);
			$mail->setFromName($from_name);
			$mail->setType('Html');
			

			 try {
				 $mail->send();
				 Mage::getSingleton('adminhtml/session')->addSuccess(
	                        Mage::helper('adminhtml')->__('Repairdevice Invoice Submit was successfully')
	                );
				 $this->_redirect('*/*/edit', array('id' => $model->getRepairdeviceId()));
				 return;
			 } catch (Exception $ex) {
				 Mage::getSingleton('core/session')->addError('Unable to Submit.');
				 $this->_redirect('*/*/');
				 return;
			 }		
             //$this->_redirect('*/*/');
			 
			  
			
		
		 }

    }

	
	public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
        	//print_r($data);exit;
            $model = Mage::getModel('repairdevice/repairdevice');

            $model->setData($data)->setRepairdeviceId($this->getRequest()->getParam('id')
            );
           try {
                $model->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('repairdevice')->__('Item was successfully saved')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
 
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getRepairdeviceId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', 
                                 array('id' => $this->getRequest()->getParam('id'))
                );
                return;
           }
        }
        Mage::getSingleton('adminhtml/session')->addError(
                  Mage::helper('repairdevice')->__('Unable to find item to save')
        );
        $this->_redirect('*/*/');
    }
	
	 public function deleteAction() 
	{
	        if( $this->getRequest()->getParam('id') > 0 ) {
	            try {
	                $model = Mage::getModel('repairdevice/repairdevice');
	                $model->setRepairdeviceId($this->getRequest()->getParam('id'))
	                      ->delete();
	                Mage::getSingleton('adminhtml/session')->addSuccess(
	                        Mage::helper('adminhtml')->__('Item was successfully deleted')
	                );
	                $this->_redirect('*/*/');
	            } catch (Exception $e) {
	                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
	                $this->_redirect('*/*/edit', 
	                                 array('id' => $this->getRequest()->getParam('id'))
	                );
	            }
	        }
	        $this->_redirect('*/*/');
	}
	


	
}
