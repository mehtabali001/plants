<style>
/*.form-group {*/
/*    margin-bottom: 0px;*/
/*}*/
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #bac1dc;
    line-height: 28px;
    padding-top: 2px;
}
.select2-dropdown {
    background-color: #212744;
    border: 1px solid #575252;
	border-bottom: 1px solid #2a2f4e;
}
.select2-container--default .select2-results__option[aria-selected=true] {
    background-color: #5897FB;
}
.select2-container--default .select2-selection--single {
    background-color: #212744;
    border: 1px solid #575252;
    border-radius: 4px;
	min-height: 36px;
}
.select2-container--default .select2-selection--multiple {
    background-color: #212744;
    border: 1px solid #575252;
    border-radius: 4px;
	min-height: 36px;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #bac1dc;
    line-height: 28px;
    padding-top: 2px;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #212744;
    font-size: 10px;
}
/*
#itemtarget{
    display:flex;
}
*/
</style>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Expenses" type="button" class="btn btn-primary btn-large"><i class="fa fa-shopping-cart"></i>&nbsp;Add Expense</a>
                  <a href="<?= base_url();?>Expenses/manage_Expenses" type="button" class="btn btn-outline-primary"><i class="fa fa-vcard"></i>&nbsp;Manage Expenses</a>
                </div>
			</div>
			<h4 class="page-title">Edit Expense</h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="javascript:void(0);">Expenses</a></li>
				<li class="breadcrumb-item active">Edit Expense</li>
			</ol>
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<form method="post" action="<?= base_url('Expenses/editProcess');?>">
				<div class="row">
				<div class="col-lg-12">
				<div class="col-lg-6" style="padding: 0px;">
				<?php $error_message = $this->session->userdata('error_message');
				   if (isset($error_message)) {
				?>
					<div class="alert alert-danger">
						<?php echo $error_message ?>                    
					</div>
				<?php
				   $this->session->unset_userdata('error_message');
				}
				?>
				<?php $success_message = $this->session->userdata('success_message');
				   if (isset($success_message)) {
				?>
					<div class="alert alert-success">
						<?php echo $success_message ?>                    
					</div>
				<?php
				   $this->session->unset_userdata('success_message');
				}
				?>
				</div>
				</div>
				</div>
				
				<div class="row">
				    <div class="col-sm-6">
                       <div class="form-group row">
                            <label for="adress" class="col-sm-4 col-form-label">Voucher Number</label>
                            <div class="col-sm-8">
								<input type="text" readonly tabindex="4" class="form-control" name="" placeholder="Voucher Number" id="fld_voucher_no" value="<?//php echo $autoVoucherID;?>">
                            </div>
                        </div> 
                    </div>
				    <div class="col-sm-6">
                        <div class="form-group row">
                                <label for="date" class="col-sm-4 col-form-label">Date <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-8">
                                   <input type="text" required="" tabindex="2" class="form-control datepicker" name="date_added" id="date_added" value="<?= date('d/m/y',strtotime($expense['date_added']));?>">
                            </div> 
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Plant(Purchase For)<i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <select class="select2 form-control mb-3 custom-select" id="plant_for" name="plant_for" required>
                                    <option value="">--Select Plant--</option>
                                    <?php 
            							$tbl_plants	=	$this->Common_model->select_where_ASC_DESC('fld_id,fld_location','tbl_locations',array('fld_status'=>1),'fld_location','ASC');
                                        if($tbl_plants->num_rows() > 0) {
                                        foreach($tbl_plants->result() as $plant){
                                    ?>
                                    <option value="<?php echo $plant->fld_id;?>" <? if($plant->fld_id == $expense['plant_for'] ){  echo "selected"; } ?>><?php echo $plant->fld_location;?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Plant(Paid From)<i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <select class="select2 form-control mb-3 custom-select" id="plant_from" name="plant_from" required>
                                    <option value="">--Select Plant--</option>
                                    <?php 
            							$tbl_plants	=	$this->Common_model->select_where_ASC_DESC('fld_id,fld_location','tbl_locations',array('fld_status'=>1),'fld_location','ASC');
                                        if($tbl_plants->num_rows() > 0) {
                                        foreach($tbl_plants->result() as $plant){
                                    ?>
                                    <option value="<?php echo $plant->fld_id;?>" <? if($plant->fld_id == $expense['plant_from'] ){  echo "selected"; } ?>><?php echo $plant->fld_location;?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
					<h4 class="form-section"><i class="icon-eye6"></i>Expence Details</h4>
				</div><hr>
				<div class="col-sm-12">
				    <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="purchaseTable">
                                <thead>
                                     <tr>
                                        <th class="text-center" style="width:18%;">Stationary<i class="text-danger">*</i></th>
                                        <th class="text-center" >Qnty</th>
                                        <th class="text-center" >unit</th>
                                        <th class="text-center">Payment Type</th>
                                        <th class="text-center">Remarks</th>
                                        <th class="text-center">Unit Price <i class="text-danger">*</i></th>
                                        <th class="text-center">Sub Total (PKR)</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="addExpenceItem">
                                    <tr>
                                        <td class="span3 supplier">
                                           <div class=" row">
                                                <div class="col-sm-8">
                                                    <div id="item_div">
                                                        <select class="select2 form-control mb-3 custom-select" id="expense_item" name="expense_item" required="required">
                                                            <?php $items	=	$this->Common_model->select_where_ASC_DESC('id,name','tbl_stationary',array('status'=>1),'name','ASC');
                                                                  if($items->num_rows() > 0) {
                                                                  foreach($items->result() as $itm) {
                                                            ?>
                                                                <option value="<?php echo $itm->id;?>" <? if($itm->id == $expense['expense_item'] ){  echo "selected"; } ?>><?php echo $itm->name;?></option>
                                                            <?php } } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            <div class="col-lg-1" >
                                                <a class="btn btn-success toggle"><i class="fa fa-plus"></i></a>
                                            </div>
                                        </div>    
                                        </td>
                                        <td class="wt">
                                            <input type="text" class="form-control total_price text-right" name="qnty" id="qnty">
                                        </td>
                                        <td class="wt">
                                            <input type="text" class="form-control total_price text-right" name="unit" id="unit">
                                        </td>
                                        <td class="span3">
                                           <select class="form-control" id="payment_type" name="payment_type" >
							                    <option value="1" <? if($expense['payment_type'] == 1 ){  echo "selected"; } ?>>Cash</option>
                    							<option value="2" <? if($expense['payment_type'] == 2 ){  echo "selected"; } ?>>Bank</option>
                    						</select>
                                        </td>
                                        <td class="wt">
                                            <input type="text" class="form-control total_price text-right" name="detail" id="detail"  placeholder="Enter Your Remarks....." value="<?=$expense['detail'];?>">
                                        </td>
                                        
                                        <td class="test">
                                            <input class="form-control" type="text" name="amount" id="amount" required placeholder="e.g 1000">
                                            <!--<input type="text" name="fld_unit_price[]" required="" onkeyup="calculate_store(1);" onchange="calculate_store(1);" id="product_rate_1" class="form-control product_rate_1 text-right" placeholder="0.00" value="" min="0" tabindex="12" aria-required="true">-->
                                        </td>
                                        <td class="text-right">
                                            <input class="form-control total_price text-right" type="text" name="" id="" value="0.00"  readonly="readonly" value="<?=$expense['amount'];?>">
                                        </td>
                                        <td>
                                            <button class="btn btn-danger text-right red" type="button" value="Delete" onclick="" ><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-right" colspan="6"><b>Total (PKR):</b></td>
                                        <td class="text-right">
                                            <input type="text" id="fld_grand_total_amount" class="text-right form-control" name="fld_grand_total_amount" value="0.00" readonly="readonly">
                                        </td>
                                        <td> 
                                        <button type="button" id="add_invoice_item" class="btn btn-success" name="add-invoice-item" onclick="addExpenceOrderField1('addExpenceItem')" ><i class="fa fa-plus"></i></button>
                                        <input type="hidden" name="baseUrl" class="baseUrl" value="http://localhost/erp/"></td>
                                    </tr>
                                    
                                </tfoot>
                            </table>
                        </div>
				</div>
				
                    <div class="col-lg-12" id="itemtarget">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Add New Stationary</label>
                            <div class="col-sm-8">
                                <input type="text" id="new_item" name="new_item" class="form-control" placeholder="Add" >
                            </div>
                            <div class="col-lg-2" id="itemtarget2">  
                               <div id="new_item_btn">
                                    <button type="button" class="btn btn-gradient-primary" onClick="submitExpenseItem();">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
				</div>
				<!--<div class="col-lg-12">-->
				<!--	<div class="mt-3">-->
				<!--		<label class="mb-2"></label>-->
				<!--		<input class="form-control" type="hidden" name="id" value="<?//=$expense['id'];?>">-->
				<!--		<button type="submit" class="btn btn-gradient-primary">Submit</button>-->
				<!--	</div>-->
				<!--</div>-->
				<div class="col-lg-12" style="padding-bottom: 20px;">
					<div class="mt-3">
						<label class="mb-2"></label>
						<input type="submit" id="add_expense" class="btn btn-gradient-primary" name="add_expense" value="Submit">
						<input type="submit" value="Submit And Add Another One" name="add-expense-another" class="btn btn-success1" id="add-expense-another">
						<input type="reset"  class="btn btn-danger btn-large" name="reset" id="Reset" value="Reset">
					</div>
				</div>
				</div>
				</form>
			</div>
			</div> <!-- end card-body -->
		</div> <!-- end card -->                                       
	</div> <!-- end col -->
</div>