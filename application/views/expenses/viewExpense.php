<style>
#datatable_filter > label
{
	float: right;
}
.label-success-outline {
    color: #506ee4;
}
.btn{
    box-shadow: none !important;
}
.bttn:hover{
    color: #fff;
    background-color: #506ee4 !important;
    border-color: #506ee4 !important;
}
</style>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-12" style="margin-bottom:1%;">
		<div class="page-title-box">
			<div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Expenses" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;Add Expense</a>
                  <a href="<?= base_url();?>Expenses/manage_Expenses" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;Manage Expenses</a>
                  <a href="<?= base_url();?>Expenses/manage_trash" type="button" class="btn btn-outline-primary"><i class="fa fa-trash"></i>&nbsp;Trash</a>
                  <a href="<?= base_url();?>Expenses/manage_drafts" type="button" class="btn btn-outline-primary"><i class="fa fa-files-o"></i>&nbsp;Drafts</a>
                </div>
			</div>
			
			<!--<h4 class="page-title">Manage Expenses</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Expenses</a></li>-->
			<!--	<li class="breadcrumb-item active">Manage Expenses</li>-->
			<!--</ol>-->
		</div>
	</div>
	<div class="col-sm-12" style="margin-bottom:1%;">
	    <div class="btn-group float-right" role="group" style="margin-top:10px;">
              <a type="button" <? if($this->uri->segment(3) != 0){ ?> onclick="window.open('<?= base_url();?>Expenses/print_single_expense/<?= $expense['id'];?>', 'Expense Report', 'width=1210, height=842');" <? }else{ echo "disabled"; } ?> id="print_report" style="border:1px solid #506ee4;background-color: DodgerBlue;" class="btn bttn print_report" name="" value=""><i class="fa fa-print" aria-hidden="true"></i>&nbsp;&nbsp;Print Current Report</a>
              <a type="button" style="border:1px solid #506ee4;background: #fd3c97" <? if($this->uri->segment(3) != 0){ ?> onclick="window.open('<?= base_url();?>Expenses/pdf_single_expense/<?= $expense['id'];?>', 'Expense Report');" <? }else{ echo "disabled"; } ?> class="btn  bttn pdf_expense_report" name="" value="" <? if($this->uri->segment(3) == 0){ echo "disabled"; } ?>><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;&nbsp;Download PDF</a>
              <a href="<?= (!empty($previous)) ? base_url('Expenses/detail/'.$previous['id'].''):'0';?>" type="button" class="btn btn-outline-primary"><i class="mdi mdi-arrow-left"></i>&nbsp;Previous Expense</a>
              <a href="<?= (!empty($next)) ? base_url('Expenses/detail/'.$next['id'].''):'0';?>" type="button" class="btn btn-outline-primary">Next Expense&nbsp;<i class="mdi mdi-arrow-right"></i></a>
        </div>
    </div>
</div><br>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
								<div class="panel panel-bd lobidrag">
								<div class="panel-body" id="printableArea">
						        <? 
						         $plantfor   =	$this->Common_model->select_single_field('fld_location','tbl_locations',array('fld_id'=>$expense['plant_for']));
								 $plantfrom  =	$this->Common_model->select_single_field('head_name','tbl_coa',array('head_code'=>$expense['plant_from']));
						         if($this->uri->segment(3) != 0){ 
						        ?>
								<div class="row purchasedetails-header">
									<div class="col-sm-8 purchasedetails-address">
										<span class="label m-r-15 p-10 text-dark font-weight-semibold"><span class="label-success-outline">Plant (Purchase For) :</span> <?=$plantfor;?></span>
										<hr>
										<ul class="list-unstyled mb-2">
											<li><b>Voucher #</b> : <?= $expense['expense_voucher'];?></li>
											<li class="mt-3"><b>Date</b> : <?= date('d-m-y',strtotime($expense['date_added']));?></li>
										</ul>
									</div>
									 
									<div class="col-sm-4 text-left invoice-details-billing">
										<span class="label m-r-15 text-dark font-weight-semibold"><span class="label-success-outline">Plant (Paid From) :</span> <?=$plantfrom;?></span>
										<!--<hr>-->
										<!--<ul class="list-unstyled mb-2">-->
										<!--	<li><b>Voucher #</b> : <?//= $expense['expense_voucher'];?></li>-->
										<!--	<li class="mt-3"><b> Date </b> : <?//= date('d-m-y',strtotime($expense['date_added']));?></li>-->
										<!--</ul>-->
									</div>
								</div><hr>
									<br>
									<div class="table-responsive">
										<table class="table table-bordered table-striped table-hover">
											<thead>
												<tr>
													<th class="text-center" style="width:18%;">Name</th>
                                                    <th class="text-center" >Qty</th>
                                                    <th class="text-center" >Exp. Type</th>
                                                    <!--<th class="text-center" >Unit</th>-->
                                                    <!--<th class="text-center">Payment Type</th>-->
                                                    <th class="text-center">Remarks</th>
                                                    <th class="text-center">Amount (PKR)</th>
                                                    <!--<th class="text-center">Sub Total (PKR)</th>-->
												</tr>
											</thead>
											<tbody>
												<?
                                                  $i = 0;
                                                  $details = $this->db->query("SELECT * FROM tbl_expense_detail WHERE fld_expense_id = '".$expense['id']."'")->result_array();
                                                  foreach($details as $det){
                                                      $stationary = $this->db->select('*')->from('tbl_stationary')->where(array('id'=>$det['stationary']))->get()->row_array();
                                                      $unit = $this->Common_model->select_single_field('fld_unit','tbl_units',array('fld_id'=>$stationary['fld_unit']));
                                    			      $i++;
                                    			      if($det['expense_type'] == 1){
												            $exptype = "Office Expense";
												        }else{
												            $exptype = "Mess Expense";
												        }
												        
                                                ?>					
												<tr>
													<td class="text-center"><?= $stationary['name'];?></td>
													<td class="text-center"><?= $det['quantity'].' '.$unit;?></td>
													<td class="text-center"><?= $exptype;?></td>
													<!--<td class="text-center"><?//= $det['unit'];?></td>-->
													<td class="text-center"><?php if(!empty($det['remarks'])){ echo $det['remarks']; }else{ echo "Nil"; } ?></td>
													<td class="text-center"><?= $det['unit_price'];?></td>
													<!--<td class="text-center"><?//= $det['sub_total'];?></td>-->
												</tr>
												<?php $i++; } ?>
											</tbody>
											<tfoot>
												<tr>
													<td class="text-right" colspan="4"><b>Total(PKR):</b></td>
													<td class="text-center"><b><?= $expense['fld_grand_total_amount'];?></b></td>
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