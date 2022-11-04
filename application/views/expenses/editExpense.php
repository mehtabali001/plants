<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<style>
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

.disabled-select {
   background-color:#d5d5d5;
   opacity:0.5;
   border-radius:3px;
   cursor:not-allowed;
   position:absolute;
   top:0;
   bottom:0;
   right:0;
   left:0;
}
select[readonly].select2-hidden-accessible + .select2-container {
  pointer-events: none;
  touch-action: none;
}

select[readonly].select2-hidden-accessible + .select2-container .select2-selection {
  background: #eee;
  box-shadow: none;
}
@media only screen and (max-width: 600px) {
  .toggle {
    display: none;
  }
}
select[readonly].select2-hidden-accessible + .select2-container .select2-selection__arrow,
select[readonly].select2-hidden-accessible + .select2-container .select2-selection__clear {
  display: none;
}
<? if(!empty($role_permissions) && in_array(107,$role_permissions)) { ?>
.addnewstationary{
    display:block;
}
<? }else{ ?>
.addnewstationary{
    display:none;
}
<? } ?>
</style>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-12" style ="margin-bottom:1%;">
		<div class="page-title-box">
			<div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Expenses" type="button" class="btn btn-primary btn-large"><i class="fa fa-money"></i>&nbsp;+ Expense</a>
                  <a href="<?= base_url();?>Expenses/manage_Expenses" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Expenses</a>
                  <a href="<?= base_url();?>Expenses/manage_trash" type="button" class="btn btn-outline-primary"><i class="fa fa-trash"></i>&nbsp;Trashed Expenses</a>
                  <a href="<?= base_url();?>Expenses/manage_drafts" type="button" class="btn btn-outline-primary"><i class="fa fa-files-o"></i>&nbsp;Drafts</a>
                </div>
			</div>
			<!--<h4 class="page-title">Edit Expense</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Expenses</a></li>-->
			<!--	<li class="breadcrumb-item active">Edit Expense</li>-->
			<!--</ol>-->
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
	<form  method="post" action="<?= base_url('Expenses/editProcess');?>" id="updateexpense">
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
	<div class="col-sm-12">
		<h4 class="form-section"><i class="icon-eye6"></i>Expense Details</h4>
	</div><hr>
	
	<div class="row">
	    <div class="col-sm-6">
           <div class="form-group row">
                <label for="adress" class="col-sm-4 col-form-label">Expense Invoice ID</label>
                <div class="col-sm-8">
					<input type="text" readonly tabindex="1" class="form-control" name="expense_voucher" placeholder="Voucher Number" id="expense_voucher" value="<?=$expense['expense_voucher'];?>">
                </div>
            </div> 
        </div>
	    <div class="col-sm-6">
            <div class="form-group row">
                    <label for="date" class="col-sm-4 col-form-label">Date <i class="text-danger">*</i></label>
                    <div class="col-sm-8">
                       <input type="text" required="" tabindex="2" class="form-control" name="date_added" id="date_added" value="<?= date('d/m/Y',strtotime($expense['date_added']));?>" readonly>
                </div> 
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Plant(Purchase For)<i class="text-danger">*</i></label>
                <div class="col-sm-8">
                    <select class="select2 form-control mb-3 custom-select" id="plant_for" name="plant_for" required tabindex="2">
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
                <label class="col-sm-4 col-form-label">Plant(Paid From)<i class="text-danger" id="f_balance">(Balance: <?=$this->CI->getBalanceInner($expense['plant_from'], $expense['fld_grand_total_amount']); ?>)</i></label>
                <div class="col-sm-8">
                    <select class="select2 form-control mb-3 custom-select" id="plant_from" name="plant_from" onchange="getBalance(this.value);" required tabindex="3">
                        <option value="">--Select Plant--</option>
                        
                         <?php 
							$plants_from	= $this->db->select('*')->from('tbl_coa')->where('head_code!=', '101009')->like('head_code', '101009', 'both')->get();
                            if($plants_from->num_rows() > 0) {
                            foreach($plants_from->result() as $plant){
                        ?>
                        <option value="<?php echo $plant->head_code;?>"<? if($plant->head_code == $expense['plant_from'] ){  echo "selected"; } ?>><?php echo $plant->head_name;?></option>
                        <?php } } ?>
                    </select>
                </div>
            </div>
        </div>
        <input type="hidden" id="plant_from_id" value="<?=$expense['plant_from'];?>" />
        <input type="hidden" id="balanceInput" value="<?=$this->CI->getBalanceInner($expense['plant_from'], $expense['fld_grand_total_amount']); ?>" />
        <div class="col-lg-6" id="itemtarget">
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Add New Stationary</label>
                <div class="col-sm-8">
                    <input type="text" id="new_item" name="new_item" class="form-control" placeholder="Add" >
                    <input type="hidden" id="row_select_id" value="0" />
                </div>
            </div>
        </div>
        
        <div class="col-lg-1" id="itemtarget2">  
           <div id="new_item_btn">
                <button type="button" class="btn btn-gradient-primary" onClick="submitExpenseItem();">Add</button>
            </div>
        </div>
	
	</div>
	<div class="col-sm-12">
		<h4 class="form-section"><i class="icon-eye6"></i>Expence Details</h4>
	</div><hr>
	<div class="col-sm-12">
	    <div class="table-responsive">
    <table class="table table-bordered table-hover" id="expenseTable">
        <thead>
             <tr>
                <th class="text-center">Type</th> 
                <!--<th class="text-center">For</th> -->
                <th class="text-center" style="width:18%;">Item<i class="text-danger">*</i></th>
                <th class="text-center" >QTY</th>
                <th class="text-center" >Unit</th>
                <!--<th class="text-center">Payment Type</th>-->
                <th class="text-center">Remarks</th>
                <th class="text-center">Amount <i class="text-danger">*</i></th>
                <!--<th class="text-center">Sub Total (PKR)</th>-->
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody id="addExpenseItem">
            <?
              $i = 0;
              $details = $this->db->query("SELECT * FROM tbl_expense_detail WHERE fld_expense_id = '".$expense['id']."'")->result_array();
              foreach($details as $det){
			  $i++;
            ?>
            <tr>
                <td class="wt">
                   <div class=" row">
                        <div class="col-sm-12">
                            <div>
                                <?//=$det['expense_value'];?>
                                <!--<select class="select2 form-control mb-3 custom-select expense_type" id="expense_type_<?=$i;?>" name="expense_type[]" onchange="expense_type(<?=$i;?>);" required="required" tabindex="4">-->
                                <!--  <option value="">--Select--</option>    -->
                                <!--  <option value="1" <?//php if($det['expense_type'] == 1){ echo "selected";} ?>>Office Expense</option>-->
                                <!--  <option value="2" <?//php if($det['expense_type'] == 2){ echo "selected";} ?>>Mess Expense</option>-->
                                <!--</select>-->
                                
                                  <select class="select2 form-control mb-3 custom-select" id="department" name="department" tabindex="3">
                                    <option value="">--Select--</option>
                                    <?php $expense_group	=	$this->Common_model->select_where_ASC_DESC('id,expense_group_name','tbl_expense_group',array('fld_isdeleted'=>0),'expense_group_name','ASC');
                                        if($expense_group->num_rows() > 0) {
                                        foreach($expense_group->result() as $exp_grp) {
                                    ?>
                                        <option value="<?php echo $exp_grp->id;?>" <? if($exp_grp->id == $det['expense_type']){ ?> selected <? } ?> ><?php echo $exp_grp->expense_group_name;?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                   </div>    
                </td>
                <?/*<td class="wt">
                   <div class=" row">
                        <div class="col-sm-12">
                            <div>
                                <select class="select2 form-control mb-3 custom-select sub_values" id="expense_value_<?=$i;?>" name="expense_value[]" required="required" tabindex="5">
                                  <option value="">--Select--</option>
                                  <?php 
                                        $expensevalues = $this->db->query("SELECT * FROM tbl_expense_type WHERE expense_type = '".$det['expense_type']."'")->result_array();
                                        foreach($expensevalues as $val) {
                                  ?>
                                  <option value="<?= $val['expense_value'];?>" <? if($val['expense_value'] === $det['expense_value']){ echo 'selected'; } ?>><?= $val['expense_value'];?></option>
								  <?php } ?>
                                </select>
                            </div>
                        </div>
                   </div>    
                </td>*/?>
                <td class="wt supplier">
                   <div class=" row">
                        <div class="col-sm-8">
                            <div id="item_div_<?=$i;?>">
                                <select class="select2 form-control mb-3 custom-select" id="fld_expense_id_<?=$i;?>" name="fld_expense_id[]" onchange="filled_units(<?=$i;?>); disablebyunitsbtn();" required="required" tabindex="6">
                                <option value="">--Select--</option>    
                                  <?php
                                  $unit = 'N/A';
									if($stationary){
									foreach($stationary as $stat){
									    if($stat['id'] === $det['stationary']){ $unit = $stat['fld_unit']; }
									?>
                                        <option value="<?php echo $stat['id'];?>"  data-unit="<?php echo $stat['fld_unit'];?>" <?php if($stat['id'] === $det['stationary']){ echo "selected";} ?>><?php echo $stat['name'];?></option>
                                  <?php } } ?>
                                </select>
                            </div>
                        </div>
                    <div class="col-lg-1 addnewstationary">
                        <a class="btn btn-success toggle" onclick="openAddForm(<?=$i;?>)"><i class="fa fa-plus"></i></a>
                    </div>
                </div>    
                </td>
                <td class="wt">
                    <input type="number" required name="quantity[]" id="quantity_<?=$i;?>" step="any" class="form-control text-right" onkeyup="calculate_store(<?=$i;?>);" oninput="this.value = Math.abs(this.value)" onchange="calculate_store(<?=$i;?>);" placeholder="0.00" value="<?=$det['quantity'];?>"  tabindex="7" aria-required="true" <?php if($det['expense_type'] == 1){ echo "readonly";} ?>>
                </td>
                <td class="wt">
                    <input type="text" name="unit[]" id="unit_<?=$i;?>" class="form-control text-center unit_input" placeholder="Unit Code" value="<?php  echo $unit; ?>" readonly tabindex="9">
                    
                </td>
     <!--           <td class="span3">-->
     <!--              <select class="select2 form-control mb-3 custom-select" id="payment_type_<?=$i;?>" name="payment_type[]" >-->
					<!--	<option value="1" <? //if($det['payment_type'] == 1 ){  echo "selected"; } ?>>Cash</option>-->
					<!--	<option value="2" <? //if($det['payment_type'] == 2 ){  echo "selected"; } ?>>Bank</option>-->
					<!--</select>-->
     <!--           </td>-->
                <td class="wt">
                    <input type="text" class="form-control total_price text-right" name="remarks[]" id="remarks_<?=$i;?>"  placeholder="Enter Your Remarks....." value="<?=$det['remarks'];?>"  tabindex="9">
                </td>
                
                <td class="test">
                    <input type="number" name="unit_price[]" required="" onkeyup="calculate_store(<?=$i;?>);" oninput="this.value = Math.abs(this.value)" onchange="calculate_store(<?=$i;?>);" id="unit_price_<?=$i;?>" class="form-control unit_price  text-right" placeholder="0.00" value="<?=$det['unit_price'];?>" min="1" aria-required="true"  tabindex="10">
                </td>
                <!--<td class="text-right">-->
                <!--    <input class="form-control sub_total text-right" type="text" name="sub_total[]" id="sub_total_<?//=$i;?>" value="<?//=$det['sub_total'];?>" readonly="readonly">-->
                <!--</td>-->
                <td>
                    <button class="btn btn-danger text-right red" type="button" value="Delete" onclick="deleteRow(this)" ><i class="fas fa-times"></i></button>
                </td>
            </tr>
            <? } $countRows = $i+1; ?>
        </tbody>
        <tfoot>
            <tr>
                <td class="text-right" colspan="5"><b>Net Amount (PKR):</b></td>
                <td class="text-right">
                    <input type="text" id="fld_grand_total_amount" class="text-right form-control" name="fld_grand_total_amount" value="<?=$expense['fld_grand_total_amount'];?>" readonly="readonly">
                    <input type="hidden" id="fld_orignal_total_amount" class="text-right form-control" name="fld_orignal_total_amount" value="<?=$expense['fld_grand_total_amount'];?>" readonly="readonly">
                </td>
                <td> 
                <button type="button" id="add_invoice_item" class="btn btn-success" name="add-invoice-item" onclick="addExpenseOrderField1('addExpenseItem')" ><i class="fa fa-plus"></i></button>
                <input type="hidden" name="baseUrl" class="baseUrl" value="https://erp.mktechsol.com">
                <input type="hidden" name="expense_id" value="<?=$expense['id'];?>"></td>
            </tr>
        </tfoot>
    </table>
    </div>
	</div>
	
	<div class="col-lg-12">
		<p style="color:red;">Note: Proceed button will be disabled till the available amount in chosen Plant either Net amount(PKR) should be less or equal.<br>Make sure you have chosen specific Unit with each item.</p>
		<div class="mt-3">
			<label class="mb-2"></label>
			<input type="submit" id="add_expense" class="btn btn-successs col-sm-2" name="add_expense" value="Proceed F10" disabled tabindex="11">
			<!--<input type="submit" value="Submit And Add Another One F6" name="add-expense-another" class="btn btn-success1" id="add-expense-another">-->
		</div>
	</div>
	</form>
			</div>
			</div> <!-- end card-body -->
		</div> <!-- end card -->                                       
	</div> <!-- end col -->
	<div id="stationarySelect" style="display:none;">
	     <?php
			if($stationary){
			foreach($stationary as $stat){
			?>
                <option value="<?php echo $stat['id'];?>"  data-unit="<?php echo $stat['fld_unit'];?>" ><?php echo $stat['name'];?></option>
          <?php } } ?>
	</div>
	<div id="typeSelect" style="display:none;">
	    <option value="">--Select --</option>
            <?php $expense_group	=	$this->Common_model->select_where_ASC_DESC('id,expense_group_name','tbl_expense_group',array('fld_isdeleted'=>0),'expense_group_name','ASC');
                if($expense_group->num_rows() > 0) {
                foreach($expense_group->result() as $exp_grp) {
            ?>
                <option value="<?php echo $exp_grp->id;?>" ><?php echo $exp_grp->expense_group_name;?></option>
            <?php } } ?>
	</div>
	<div id="unitsSelect" style="display:none;">
	<?php
		if($units){
		foreach($units as $sup){
	?>
		<option value="<?= $sup['fld_id'];?>" data_set="<?= $sup['fld_unit'];?>"><?= $sup['fld_unit'];?></option>
	<?php }}?>
	</div>
	<div id="paymenttypeSelect" style="display:none;">
		<option value="1">Cash</option>
		<option value="2">Bank</option>
	</div>
</div><!-- container -->
<input type="hidden" id="countRows" value="<?=$countRows;?>" />
<script>
        function disablebyunitsbtn(){
            var isenabled = true;
            	$(".unit_input").each(function() {
			console.log('value'+'===='+this.value);
			if(this.value == ""){
				isenabled =false;
			}
            //isNaN(this.value) || 0 == this.value.length || (gr_tot += parseFloat(this.value))
        });
        if(!isenabled){
            buttons_function(0);
        }else{
            buttons_function(1);
        }
        
        }
        
    </script>