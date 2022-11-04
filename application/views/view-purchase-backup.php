<style>
#datatable_filter > label
{
	float: right;
}
.label-success-outline {
    color: #45c203;
    background-color: transparent;
    border: 2px solid #45c203;
}

</style>
<div class="container-fluid">
<!--<div class="row">-->
<!--	<div class="col-sm-12">-->
<!--		<div class="page-title-box">-->
<!--			<div class="float-right">-->
				
<!--			</div>-->
<!--			<h4 class="page-title">Purchase Detail</h4>-->
<!--		</div><!--end page-title-box-->
<!--	</div><!--end col-->
<!--</div>-->
<!-- end page title end breadcrumb -->
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Purchase" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;Create Purchase</a>
                  <a href="<?= base_url();?>Purchase/manage_purchase" type="button" class="btn btn-outline-primary"><i class="fa fa-vcard"></i>&nbsp;Manage Purchase</a>
                  <a href="<?= base_url();?>Purchase/manage_drafts" type="button" class="btn btn-outline-primary"><i class="fa fa-files-o"></i>&nbsp;Purchase Order</a>
                  <a href="<?= base_url();?>Purchase/purchReport" type="button" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;Purchase Report</a><br>
                </div><br>
               <div class="btn-group float-right" role="group" style="margin-top:10px;">
                    <a href="" type="button" class="btn btn-outline-primary"><i class="mdi mdi-arrow-left"></i>&nbsp;Previous Purchase</a>
                     <a href="" type="button" class="btn btn-outline-primary">Next Purchase&nbsp;<i class="mdi mdi-arrow-right"></i></a>
                </div>
			</div>
			<h4 class="page-title">Purchase Detail</h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="javascript:void(0);">ERP</a></li>
				<li class="breadcrumb-item active">Purchase Detail</li>
			</ol>
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
										<h4><strong>Purchase Details</strong></h4>
										
									</div>
								</div>
								<div class="panel-body" id="printableArea">
						
								<div class="row purchasedetails-header">
											
									<div class="col-sm-8 purchasedetails-address">
										<span class="label label-success-outline m-r-15 p-10">Billing From</span>
										<p class="text-muted  mt-3"><span class="text-dark font-weight-semibold">FastTech Solutions</span></p>
										<ul class="list-unstyled mb-2">
											<li class=""> <b>Mobile</b> : 0900101111</li>
											<li class="mt-3"><b> Email </b> :Info@fasttech.com</li>
											<li class="mt-3"><b> Website </b> : https://fast-techsolution.com/</li>                                        
										</ul>
									</div>
									
									 
									<div class="col-sm-4 text-left invoice-details-billing">
										<h2 class="m-t-0">Purchase</h2>
										<ul class="list-unstyled mb-2">
											<li class=""> <b>Invoice No</b> : <?= $purchase['fld_invoice_no'];?></li>
											<li class="mt-3"><b> Billing Date </b> : <?= date('d - M - Y',strtotime($purchase['fld_purchase_date']));?></li>
											                                        
										</ul>
										<span class="label label-success-outline m-r-15">Billing To</span>
										<p class="text-muted  mt-3"><span class="text-dark font-weight-semibold"><?= $purchase['fld_supplier_name'];?></span></p>
										
									</div>
								</div> 

									  <br>


									<div class="table-responsive">
										<table class="table table-bordered table-striped table-hover">
											<thead>
												<tr>
													<th>SL.</th>
													<th>Product Name</th>
													<th class="text-center">Qnty</th>
													<th class="text-center">Rate</th>
													<th class="text-center">Total Amount</th>
												</tr>
											</thead>
											<tbody>
												<?php if($purchase){
													$i=1;
													foreach($purchase['products'] as $purch){
													?>						
												<tr>
													<td><?= $i;?></td>
													<td>
														<?= $purch['fld_category'];?>
													</td>
													<td class="text-center"><?= $purch['fld_quantity'];?></td>
													<td class="text-center"><?= $purch['fld_unit_price'];?></td>
													<td class="text-center"><?= $purch['fld_total_amount'];?></td>
												</tr>
													<?php $i++; }}?>
																			</tbody>
											<tfoot>
												<tr>
													<td class="text-right" colspan="4"><b>Total:</b></td>
													<td class="text-center"><b><?= $purchase['fld_grand_total_amount'];?></b></td>
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

                