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
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right" style="margin-bottom: 15px;">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Navigations" type="button" class="btn btn-outline-primary"><i class='fas fa-route'></i>&nbsp;Intransit Navigations</a>
                  <a href="<?= base_url();?>Navigations/manage" type="button" class="btn btn-primary btn-large"><i class='fa fa-eye'></i>&nbsp;View Navigations</a>
                  <a href="<?= base_url();?>Navigations/createIntNav" type="button" class="btn btn-outline-primary"><i class='fas fa-rocket'></i>&nbsp;New Navigations</a>
                   <a href="<?= base_url();?>Navigations/navigationReport" type="button" class="btn btn-outline-primary"><i class='fa fa-bar-chart'></i>&nbsp;Navigations Report</a>
                </div>
			</div>
			
		</div><!--end page-title-box-->
	</div><!--end col-->
	<div class="col-sm-12">
	    <div class="btn-group float-right" role="group" style="margin-bottom: 15px;">
            <a type="button" <? if($this->uri->segment(3) != 0){ ?> onclick="window.open('<?= base_url();?>Navigations/print_single_navigation/<?= $navigation['fld_id'];?>', 'Navigation Report', 'width=1210, height=842');"<? }else{ echo "disabled"; } ?>  id="print_report" style="border:1px solid #506ee4;background-color: DodgerBlue;" class="btn bttn print_report" name="" value=""><i class="fa fa-print" aria-hidden="true"></i>&nbsp;&nbsp;Print Current Report</a>
            <a type="button" style="border:1px solid #506ee4;background: #fd3c97" <? if($this->uri->segment(3) != 0){ ?> onclick="window.open('<?= base_url();?>Navigations/pdf_single_navigation/<?= $navigation['fld_id'];?>', 'Navigation Report');"<? }else{ echo "disabled"; } ?>  class="btn  bttn pdf_purchase_report" name="" value=""<? if($this->uri->segment(3) == 0){ echo "disabled"; } ?>><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;&nbsp;Download PDF</a>
            <a href="<?= (!empty($previous)) ? base_url('Navigations/detail/'.$previous['fld_id'].''):'0';?>"  type="button" class="btn btn-outline-primary"><i class="mdi mdi-arrow-left"></i>&nbsp;Previous Navigation</a>
            <a href="<?= (!empty($next)) ? base_url('Navigations/detail/'.$next['fld_id'].''):'0';?>" type="button" class="btn btn-outline-primary">Next Navigation&nbsp;<i class="mdi mdi-arrow-right"></i></a>
        </div>
	</div>    
</div>
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
										<span class="label m-r-15 p-10 text-dark font-weight-semibold"><span class="label-success-outline">Navigation Invoice From :</span> <?=$billfrom->bill_from; ?></span>
										<hr>
										<!--<p class="text-muted  mt-3"><span class="text-dark font-weight-semibold">FastTech Solutions</span></p>-->
										<ul class="list-unstyled mb-2">
											
									        <li class="mt-3"><b>Navigation Invoice ID</b> : <?php echo sprintf(' NI-%04d ', $navigation['fld_id']);?></li>
									<? /* ?><li class="mt-3"><b>Freight MT </b> : <?php echo $navigation['fld_freight_MT'];?></li>
											<li class="mt-3"><b>Freight Amount </b> : <?php echo $navigation['fld_freight_amount'];?></li><? */ ?>
										</ul>
									</div>
									
									 
									<div class="col-sm-4 text-left invoice-details-billing">
										<!--<h2 class="m-t-0">Purchase</h2>-->
										
										<span class="label m-r-15 text-dark font-weight-semibold"><span class="label-success-outline">Navigation Invoice For :</span> <? echo $navigation['location_to'];?></span>
										<!--<p class="text-muted  mt-3"><span class="text-dark font-weight-semibold"><?//= $purchase['fld_supplier_name'];?></span></p>-->
										<hr>
										<ul class="list-unstyled mb-2">
											<!--<li class=""> <b>Invoice No</b> : <?//= $purchase['fld_invoice_no'];?></li>-->
											<li class="mt-3"><b> Navigation Date </b> : <?php echo date('d-m-Y',strtotime($navigation['fld_date']));?></li>
										</ul>
									</div>
								</div> <hr>
								<br>
									<div class="table-responsive">
										<table class="table table-bordered table-striped table-hover">
											<thead>
											<tr>
                                            <th>Navigation Date</th>
                                            <th>Invoice ID</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Item</th>
                                            <th>Shipment</th>
                                            <!--<th>Shipment To</th>-->
                                            <!--<th>Remarks</th>-->
                                            <!--<th>Weight</th>-->
                                            <th>Weight(MT)</th>
                                            <th>Rate(PKR)</th>
                                            <th>Amount(PKR)</th>
                                        </tr>
											</thead>
											<tbody>
											    <?php 
											    $total = 0;
											    foreach($navigation['products'] as $navdet){
											    $total += $navdet['fld_amount'];?>
											<tr>					
												<td>
												<?php echo date('d-m-Y',strtotime($navigation['fld_created_date']));?>
												</td>
												<td>
												<?php echo sprintf(' NV-%04d ', $navigation['fld_id']);?>
												
												</td>
												<td>
												<? echo $navigation['location_from'];?>
												</td>
												<td>
												<? echo $navigation['location_to'];?>
												</td>
												
												<td>
												<?php 
												     $catname =	$this->Common_model->select_single_field('fld_category','tbl_category',array('fld_id'=>$navdet['fld_product_id'])); 
                    							      if($catname == 'LPG'){
                    							         echo $catname;
                    							      }else{
                    							      $subcatname =	$this->Common_model->select_single_field('fld_subcategory','tbl_subcategory',array('fld_subcid'=>$navdet['fld_subproduct_id'])); 
                    							         echo $subcatname;
                    							      }
												
												;?>
												
												</td>
												<td style="font-size:12px;padding:3px;">
												<?php echo $navdet['fld_shipment_from'];?>
												
												</td>
												<td>
												<?php echo $navdet['fld_qty'];?>
												</td>
												<td>
												<?php echo $navdet['fld_rate'];?>
												</td>
												<td>
												<?php echo number_format($navdet['fld_amount'],2);?>
												</td>
												</tr>
												<?php } ?>
												</tbody>
											<tfoot>
											    <tr>
													<td class="text-right" colspan="8"><b>Freight MT:</b></td>
													<td class="text-center"><b><?php echo $navigation['fld_freight_MT'];?></b></td>
												</tr>
												<tr>
													<td class="text-right" colspan="8"><b>Freight Amount:</b></td>
													<td class="text-center"><b><?php echo number_format($navigation['fld_freight_amount'],2);?></b></td>
												</tr>
												<tr>
													<td class="text-right" colspan="8"><b>Net Total(PKR):</b></td>
													<td class="text-center"><b><?php echo number_format($total + $navigation['fld_freight_amount'],2);?></b></td>
												</tr>
													
											<!--																								</tfoot>-->
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