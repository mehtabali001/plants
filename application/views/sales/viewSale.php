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
		<div class="page-title-box">
			<div class="float-right">
				<div class="btn-group float-right" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Sales" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;New Sale</a>
                  <a href="<?= base_url();?>Sales/manage_sales" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Sales</a>
                  <a href="http://erp.techamore.us/Sales/manage_drafts" type="button" class="btn btn-outline-primary"><i class="fa fa-files-o"></i>&nbsp; Drafts</a>
                  <a href="<?= base_url();?>Sales/salesReport" style="border-top-right-radius:4px;border-bottom-right-radius:4px" type="button" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;Sales Report</a><br>
                </div>
                <br>
                <div class="btn-group float-right" role="group" style="margin-top:10px;">
                    <a type="button"onclick="window.open('<?= base_url();?>Sales/print_single_sale/<?= $sale['fld_id'];?>', 'Purchase Report', 'width=1210, height=842');" id="print_report" style="border:1px solid #506ee4;background-color: DodgerBlue;" class="btn bttn print_report" name="" value=""><i class="fa fa-print" aria-hidden="true"></i>&nbsp;&nbsp;Print Current Report</a>
                    <a type="button " style="border:1px solid #506ee4;background: #fd3c97" onclick="window.open('<?= base_url();?>Sales/pdf_single_sale/<?= $sale['fld_id'];?>', 'Purchase Report');" class="btn  bttn pdf_purchase_report" name="" value=""><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;&nbsp;Download PDF</a>
                    <a href="<?= (!empty($previous)) ? base_url('Sales/detail/'.$previous['fld_id'].''):'javascript:;';?>" type="button" class="btn btn-outline-primary"><i class="mdi mdi-arrow-left"></i>&nbsp;Previous Sale</a>
                    <a href="<?= (!empty($next)) ? base_url('Sales/detail/'.$next['fld_id'].''):'javascript:;';?>" type="button" class="btn btn-outline-primary">Next Sale&nbsp;<i class="mdi mdi-arrow-right"></i></a>
                </div>
               
			</div>
			
			<!--<h4 class="page-title">Sale Invoice Details</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Sales</a></li>-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">View Sales</a></li>-->
			<!--	<li class="breadcrumb-item active">Invoice Details</li>-->
			<!--</ol>-->
		</div><!--end page-title-box-->
	</div>
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
								<div class="row purchasedetails-header">
								    <? $billfrom = $this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row(); ?>
									<div class="col-sm-8 purchasedetails-address">
										<span class="label m-r-15 p-10 text-dark font-weight-semibold"><span class="label-success-outline">Invoice From :</span> <?=$billfrom->bill_from; ?></span>
										<hr>
										<!--<p class="text-muted  mt-3"><span class="text-dark font-weight-semibold">FastTech Solutions</span></p>-->
										<ul class="list-unstyled mb-2">
											<li class=""> <b>Plant</b> : <?php echo $sale['fld_location']; ?></li>
											<!--<li class="mt-3"><b> Shipment # </b> : <?php //echo $sale['fld_shipment']; ?></li>-->
											<li class="mt-3"><b> Vehicle # </b> : <?php echo $sale['fld_vehicle_no']; ?></li>                                        
										</ul>
									</div>
									 
									<div class="col-sm-4 text-left invoice-details-billing">
										<!--<h2 class="m-t-0">Purchase</h2>-->
										<span class="label m-r-15 text-dark font-weight-semibold"><span class="label-success-outline">Invoice For :</span> <?= $sale['fld_customer_name'];?></span>
										<!--<p class="text-muted mt-3"><span class="text-dark font-weight-semibold"><?//= $purchase['fld_supplier_name'];?></span></p>-->
										<hr>
										<ul class="list-unstyled mb-2">
										    <li class=""> <b>Invoice ID</b> : <?= $sale['fld_voucher_no'];?></li>
											<li class="mt-3"> <b>Invoice No</b> : <?= $sale['fld_invoice_no'];?></li>
											<li class="mt-3"><b> Invoice Date </b> : <?= date('d/m/Y',strtotime($sale['fld_sale_date']));?></li>
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
													<th>Shipment</th>
													<th class="text-center">Qty</th>
													<th class="text-center">Weight(KG)</th>
													<th class="text-center">Rate(PKR)</th>
													<th class="text-center">Discount(PKR)</th>
													<th class="text-center">Total(PKR)</th>
												</tr>
											</thead>
											<tbody>
												<?php if($sale){
													$i=1;
													foreach($sale['products'] as $saledet){
													?>						
												<tr>
													<td><?= $i;?></td>
													<td>
														<?= $saledet['fld_category'];?> - <?= $saledet['fld_subcategory']; ?>
													</td>
													<td class="text-center"><?= $saledet['fld_shipment'];?></td>
													<td class="text-center"><?= $saledet['fld_quantity'];?></td>
													<td class="text-center"><?= $saledet['fld_weight'];?></td>
													<td class="text-center"><?= $saledet['fld_unit_price'];?></td>
													<td class="text-center"><?=round( $saledet['fld_discount'],2);?></td>
													<td class="text-center"><?= round( $saledet['fld_total_amount']-$saledet['fld_discount'], 2);?></td>
												</tr>
													<?php $i++; }}?>
												</tbody>
											<tfoot>
											    <tr>
													<td class="text-right" colspan="7"><b>Discount(PKR):</b></td>
													<td class="text-center"><b><?= $sale['fld_discount'];?></b></td>
												</tr>
											    <tr>
													<td class="text-right" colspan="7"><b>Total Discount(PKR):</b></td>
													<td class="text-center"><b><?= $sale['fld_total_discount'];?></b></td>
												</tr>
												<tr>
													<td class="text-right" colspan="7"><b>Net Total(PKR):</b></td>
													<td class="text-center"><b><?= $sale['fld_grand_total_amount'];?></b></td>
												</tr>
											</tfoot>
										</table>
									</div>
								</div>
							</div>	
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->
</div>

                