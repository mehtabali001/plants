<style>
#datatable_filter > label
{
	float: right;
}
.label-success-outline {
    color: #506ee4;
    /*background-color: transparent;*/
    /*border: 2px solid #45c203;*/
}
.btn{
    box-shadow: none !important;
}
.bttn:hover{
    color: #fff;
    background-color: #506ee4 !important;
    border-color: #506ee4 !important;
}
@media only screen and (max-width: 600px) {
.page-title-box{
    display:none;
}
.btn-group a{
font-size: 10px;
}
.btn-group a i {
    display: block;
}
}
</style>
<div class="container-fluid">

<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box" style="padding-bottom:0 !important;">
			<div class="float-right">
				<div class="btn-group" style="float:right;" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Purchase" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;New Purchase Bill</a>
                  <a href="<?= base_url();?>Purchase/manage_purchase" type="button" class="btn btn-primary btn-large"><i class="fa fa-eye"></i>&nbsp;View Bills</a>
                  <a href="<?= base_url();?>Purchase/manage_drafts" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Orders</a>
                  <a href="<?= base_url();?>Purchase/purchReport"style="border-top-right-radius:4px;border-bottom-right-radius:4px" type="button" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;Purchase Report</a><br>
                </div><br>
                <div class="btn-group float-right" role="group" style="margin-top:10px;">
                  <a type="button" <? if($this->uri->segment(3) != 0){ ?> onclick="window.open('<?= base_url();?>purchase/print_single_purchase/<?= $purchase['fld_id'];?>', 'Purchase Report', 'width=1210, height=842');" <? }else{ echo "disabled"; } ?> id="print_report" style="border:1px solid #506ee4;background-color: DodgerBlue;" class="btn bttn print_report" name="" value=""><i class="fa fa-print" aria-hidden="true"></i>&nbsp;&nbsp;Print Current Report</a>
                  <a type="button" style="border:1px solid #506ee4;background: #fd3c97" <? if($this->uri->segment(3) != 0){ ?> onclick="window.open('<?= base_url();?>purchase/pdf_single_purchase/<?= $purchase['fld_id'];?>', 'Purchase Report');" <? }else{ echo "disabled"; } ?> class="btn  bttn pdf_purchase_report" name="" value="" <? if($this->uri->segment(3) == 0){ echo "disabled"; } ?>><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;&nbsp;Download PDF</a>
                  <a href="<?= (!empty($previous)) ? base_url('Purchase/detail/'.$previous['fld_id'].''):'0';?>" type="button" class="btn btn-outline-primary"><i class="mdi mdi-arrow-left"></i>&nbsp;Previous Purchase</a>
                  <a href="<?= (!empty($next)) ? base_url('Purchase/detail/'.$next['fld_id'].''):'0';?>" type="button" class="btn btn-outline-primary"><i class="mdi mdi-arrow-right"></i>&nbsp;Next Purchase</a>
            </div>
			</div>
			
			<!--<h4 class="page-title">Purchase Bills</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Purchase</a></li>-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Manage Purchase</a></li>-->
			<!--	<li class="breadcrumb-item active">Bill Details</li>-->
			<!--</ol>-->
		</div><!--end page-title-box-->
		
	</div><!--end col-->
</div><br>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
								<div class="panel panel-bd lobidrag">
								<div class="panel-heading">
									<div class="panel-title">
										<!--<h4><strong>Purchase Details</strong></h4>-->
									</div>
								</div>
								<div class="panel-body" id="printableArea">
						        <?//=$this->uri->segment(3);?>
						        <? if($this->uri->segment(3) != 0){ ?>
								<div class="row purchasedetails-header">
								  <? $billfrom = $this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row(); ?>
									<div class="col-sm-8 purchasedetails-address">
										<span class="label m-r-15 p-10 text-dark font-weight-semibold"><span class="label-success-outline"> Bill From :</span> <?=$billfrom->bill_from; ?></span>
										<hr>
										<!--<p class="text-muted  mt-3"><span class="text-dark font-weight-semibold">FastTech Solutions</span></p>-->
										<ul class="list-unstyled mb-2">
											<!--<li class=""> <b>Mobile</b> : 0900101111</li>-->
											<!--<li class="mt-3"><b> Email </b> :Info@fasttech.com</li>-->
											<!--<li class="mt-3"><b> Website </b> : https://fast-techsolution.com/</li> -->
											<li><b>Shipment</b> : <?= $purchase['fld_shipment'];?></li>
											<li class="mt-3"><b>Bill ID</b> : <?= $purchase['fld_voucher_no'];?></li>
										</ul>
									</div>
									 
									<div class="col-sm-4 text-left invoice-details-billing">
										<!--<h2 class="m-t-0">Purchase</h2>-->
										<span class="label m-r-15 text-dark font-weight-semibold"><span class="label-success-outline">Bill For :</span> <?= $purchase['fld_supplier_name'];?></span>
										<!--<p class="text-muted  mt-3"><span class="text-dark font-weight-semibold"><?//= $purchase['fld_supplier_name'];?></span></p>-->
										<hr>
										<ul class="list-unstyled mb-2">
											<li class=""> <b>Invoice No</b> : <?= $purchase['fld_invoice_no'];?></li>
											<li class="mt-3"><b> Billing Date </b> : <?= date('d-m-y',strtotime($purchase['fld_purchase_date']));?></li>
										</ul>
									</div>
								</div><hr>
									<br>
									<div class="table-responsive">
										<table class="table table-bordered table-striped table-hover">
											<thead>
												<tr>
													<th>#</th>
													<th>Product Name</th>
													<th class="text-center">Qty</th>
													<th class="text-center">Rate(PKR)</th>
													<th class="text-center">Total Amount(PKR)</th>
												</tr>
											</thead>
											<tbody>
												<?php if($purchase){
													$i=1;
													foreach($purchase['products'] as $purch){
													    $subcat = '';
                                					    if($purch['fld_subproduct_id'] != '0'){
                                					        $subcat = ' - '.$this->db->query("select * from tbl_subcategory where fld_subcid = '{$purch['fld_subproduct_id']}'")->row()->fld_subcategory;
                                					    }
												?>						
												<tr>
													<td><?= $i;?></td>
													<td>
														<?= $purch['fld_category'].$subcat;?>
													</td>
													<td class="text-center"><?= $purch['fld_quantity'];?></td>
													<td class="text-center"><?= $purch['fld_unit_price'];?></td>
													<td class="text-center"><?= $purch['fld_total_amount'];?></td>
												</tr>
												<?php $i++; }}?>
											</tbody>
											<tfoot>
												<tr>
													<td class="text-right" colspan="4"><b>Net Total(PKR):</b></td>
													<td class="text-center"><b><?= $purchase['fld_grand_total_amount'];?></b></td>
												</tr>
											</tfoot>
										</table>
									</div>
									<? }else{ ?>
									 <h2 style="text-align:center;">No Record Found!</h2>
									<? } ?>
						</div>
					</div>	
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
</div>