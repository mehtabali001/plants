<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<style>
@media only screen and (max-width: 600px){
    #add_expense, #add-expense-another,#add_expense_draft, #Reset {
    margin-bottom: 5px;
}
}
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
.select2-container{
    width:100%;
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

select[readonly].select2-hidden-accessible + .select2-container .select2-selection__arrow,
select[readonly].select2-hidden-accessible + .select2-container .select2-selection__clear {
  display: none;
}
@media only screen and (max-width: 600px) {
  .toggle {
    display: none;
  }
}

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
	<div class="col-sm-12" style="margin-bottom:2%;">
		<div class="page-title-box">
			<div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Expenses" type="button" class="btn btn-primary btn-large"><i class="fa fa-money"></i>&nbsp;+ Expense</a>
                  <a href="<?= base_url();?>Expenses/manage_Expenses" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Expenses</a>
                  <a href="<?= base_url();?>Common/addStationary" type="button" class="btn btn-outline-primary"><i class="fa fa-money"></i>&nbsp;+ Expense Item</a>
                  <a href="<?= base_url();?>Common/manage_stationary" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Expense Item</a>
                </div>
			</div>
			<!--<h4 class="page-title">+ Expense</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Expenses</a></li>-->
			<!--	<li class="breadcrumb-item active">New Expense</li>-->
			<!--</ol>-->
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
	<form id="addExpense" method="post" action="<?= base_url('Expenses/add');?>">
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
		<h4 class="form-section"><i class="icon-eye6"></i>Invoice Details</h4>
	</div><hr>
	
	<div class="row">
	    <div class="col-sm-6">
           <div class="form-group row">
                <label for="adress" class="col-sm-4 col-form-label">Expense Invoice ID</label>
                <div class="col-sm-8">
					<input type="text" readonly tabindex="1" class="form-control" name="expense_voucher" placeholder="Voucher Number" id="expense_voucher" value="<?php echo $autoVoucherID;?>">
                </div>
            </div> 
        </div>
	    <div class="col-sm-6">
            <div class="form-group row">
                    <label for="date" class="col-sm-4 col-form-label">Expense Date <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-8">
                       <input type="text" required="" tabindex="2" class="form-control datepicker" name="date_added" id="date_added" >
                </div> 
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Plant(Purchase For)<i class="text-danger">*</i></label>
                <div class="col-sm-8">
                    <select class="select2 form-control mb-3 custom-select" id="plant_for" name="plant_for" required tabindex="3">
                        <option value="">--Select Plant--</option>
                        <?php 
							$tbl_plants	=	$this->Common_model->select_where_ASC_DESC('fld_id,fld_location','tbl_locations',array('fld_status'=>1, 'fld_id!='=>4),'fld_location','ASC');
                            if($tbl_plants->num_rows() > 0) {
                            foreach($tbl_plants->result() as $plant){
                        ?>
                        <option value="<?php echo $plant->fld_id;?>" <? if (!empty($_GET['plants']) && $_GET['plants'] == $plant->fld_id){ echo "selected"; } ?>><?php echo $plant->fld_location;?></option>
                        <?php } } ?>
                    </select>
                </div>
            </div>
        </div>
        <input type="hidden" id="balanceInput" value="" />
        <div class="col-lg-6">
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Plant(Paid From)<i class="text-danger" id="f_balance">(Balance: 0)</i></label>
                <div class="col-sm-8">
                    <select class="select2 form-control mb-3 custom-select" id="plant_from" name="plant_from" onchange="getBalance(this.value);" required tabindex="4">
                        <option value="">--Select Plant--</option>
                        <?php 
							$plants_from	= $this->db->select('*')->from('tbl_coa')->where('head_code!=', '101009')->like('head_code', '101009', 'both')->get();
                            if($plants_from->num_rows() > 0) {
                            foreach($plants_from->result() as $plant){
                        ?>
                        <option value="<?php echo $plant->head_code;?>"><?php echo $plant->head_name;?></option>
                        <?php } } ?>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6" id="itemtarget">
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Add New Stationary</label>
                <div class="col-sm-8">
                    <input type="text" id="new_item" name="new_item" class="form-control" placeholder="Add" >
                    <input type="hidden" id="row_select_id" value="0" />
                </div>
            </div>
        </div>
        
        <div class="col-lg-6" id="itemtarget2"> 
           <div class="form-group row">
				<label class="col-sm-2 col-form-label">Unit </label>
				<div class="col-sm-6">
				<select class="select2 form-control mb-3 custom-select" id="fld_unit" name="fld_unit">
					<option value="">Select Unit</option>
					<?php
						if($units){
						foreach($units as $unit){
					?>
						<option value="<?= $unit['fld_id'];?>"><?= $unit['fld_unit'];?></option>
					<?php }} ?>
				</select>
				</div>
				<div id="new_item_btn">
                <button type="button" class="btn btn-gradient-primary" onClick="submitExpenseItem();">Add</button>
            </div>
			</div>
           
        </div>
	
	</div>
	<div class="col-sm-12">
		<h4 class="form-section"><i class="icon-eye6"></i>Expense Details</h4>
	</div><hr>
	<div class="col-sm-12">
	    <div class="table-responsive">
    <table class="table table-bordered table-hover" id="expenseTable">
        <thead>
             <tr>
                <th class="text-center">Type</th> 
                <!--<th class="text-center">For</th>-->
                <th class="text-center" style="width:18%;">Item<i class="text-danger">*</i></th>
                <th class="text-center" >Qty</th>
                <th class="text-center" >Unit</th>
                <!--<th class="text-center">Payment Type</th>-->
                <th class="text-center">Remarks</th>
                <th class="text-center">Amount <i class="text-danger">*</i></th>
                <!--<th class="text-center">Sub Total (PKR)</th>-->
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody id="addExpenseItem">
            <tr>
                <td class="wt">
                   <div class=" row">
                        <div class="col-sm-12">
                            <div>
                                <!--<select class="select2 form-control mb-3 custom-select expense_type" id="expense_type_1" name="expense_type[]" onchange="expense_type(1);" required="required" tabindex="5">-->
                                <!--  <option value="">--Select--</option>    -->
                                <!--  <option value="1">Office Expense</option>-->
                                <!--  <option value="2">Mess Expense</option>-->
                                <!--</select>-->
                                <select class="select2 form-control mb-3 custom-select" id="expense_type_1" name="expense_type[]"  required tabindex="3">
                                    <option value="">--Select --</option>
                                    <?php $expense_group	=	$this->Common_model->select_where_ASC_DESC('id,expense_group_name','tbl_expense_group',array('fld_isdeleted'=>0),'expense_group_name','ASC');
                                        if($expense_group->num_rows() > 0) {
                                        foreach($expense_group->result() as $exp_grp) {
                                    ?>
                                        <option value="<?php echo $exp_grp->id;?>" ><?php echo $exp_grp->expense_group_name;?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                   </div>    
                </td>
               
                <td class="wt supplier">
                   <div class=" row">
                        <div class="col-sm-8">
                            <div id="item_div_1">
                                <select class="select2 form-control mb-3 custom-select" id="fld_expense_id_1" name="fld_expense_id[]" onchange="filled_units(1); disablebyunitsbtn();" required="required" tabindex="7">
                                  <option value="">--Select--</option>    
                                  <? /* ?><?php $items	= $this->Common_model->select_where_ASC_DESC('id,name,fld_unit','tbl_stationary',array('status'=>1),'name','ASC');
                                        if($items->num_rows() > 0) {
                                        foreach($items->result() as $itm) {
                                  ?>
                                        <option value="<?php echo $itm->id;?>" data-unit="<?= $itm->fld_unit;?>"><?php echo $itm->name;?></option>
                                  <?php } } ?><? */?>
                                  <?php
									if($stationary){
									foreach($stationary as $stat){
									?>
									<option value="<?php echo $stat['id'];?>" data-unit="<?php echo $stat['fld_unit'];?>"><?php echo $stat['name'];?></option>
                                  <?php } } ?>
                                </select>
                            </div>
                        </div>
                        
                    <div class="col-lg-1 addnewstationary">
                        <a class="btn btn-success toggle" onclick="openAddForm(1)"><i class="fa fa-plus"></i></a>
                    </div>
                </div>    
                </td>
                <td class="wt">
                    <input type="number" required name="quantity[]" id="quantity_1" step="any" class="form-control text-right" onkeyup="calculate_store(1);" onchange="calculate_store(1);" placeholder="0.00"  aria-required="true"  tabindex="8" oninput="this.value = Math.abs(this.value)">
                </td>
                <td class="wt">
                    <input type="text" name="unit[]" id="unit_1" class="form-control text-center unit_input" placeholder="Unit Code" readonly tabindex="9">
                    <? /* ?><select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="unit[]" id="unit_1" required  tabindex="9">
                    <option selected="selected" value="0">Select unit</option>
					<?php
					if($units){
					foreach($units as $sup){
					?>
					<option value="<?= $sup['fld_id'];?>" data_set="<?= $sup['fld_unit'];?>"><?= $sup['fld_unit'];?></option>
					<?php }}?>
                    </select><? */ ?>
                </td>
     <!--           <td class="span3">-->
     <!--              <select class="select2 form-control mb-3 custom-select" id="payment_type_1" name="payment_type[]" >-->
					<!--	<option value="1">Cash</option>-->
					<!--	<option value="2">Bank</option>-->
					<!--</select>-->
     <!--           </td>-->
                <td class="wt">
                    <input type="text" class="form-control text-right" name="remarks[]" id="remarks_1"  placeholder="Enter Your Remarks....."  tabindex="10">
                </td>
                
                <td class="test">
                    <input type="number" name="unit_price[]" required="" onkeyup="calculate_store(1);" onchange="calculate_store(1);" id="unit_price_1" class="form-control unit_price text-right" placeholder="0.00" value="" min="1" aria-required="true" oninput="this.value = Math.abs(this.value)" tabindex="11">
                </td>
                <!--<td class="text-right">
                    <input class="form-control sub_total text-right" type="text" name="sub_total[]" id="sub_total_1" value="0.00" readonly="readonly">
                </td>-->
                <td>
                    <button class="btn btn-danger text-right red" type="button" value="Delete" onclick="deleteRow(this)" ><i class="fas fa-times"></i></button>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td class="text-right" colspan="5"><b>Net Amount (PKR):</b></td>
                <td class="text-right">
                    <input type="text" id="fld_grand_total_amount" class="text-right form-control" name="fld_grand_total_amount" value="0.00" readonly="readonly">
                     <input type="hidden" id="fld_orignal_total_amount" class="text-right form-control" name="fld_orignal_total_amount" value="0" readonly="readonly">
                </td>
                <td> 
                <button type="button" id="add_invoice_item" class="btn btn-success" name="add-invoice-item" onclick="addExpenseOrderField1('addExpenseItem')" ><i class="fa fa-plus"></i></button>
                <input type="hidden" name="baseUrl" class="baseUrl" value="http://erp.techamore.us"></td>
            </tr>
        </tfoot>
    </table>
    </div>
	</div>
	<div class="form-group row">
	<div class="" style=" margin-left: 2%;">
		<p style="color:red;">Note: Proceed button will be disabled till the available amount in chosen Plant either Net amount(PKR) should be less or equal.<br>Make sure you have chosen specific Unit with each item.</p>
			<!--<label class="mb-2"></label>-->
			    <input type="submit" id="add_expense" class="btn btn-successs col-sm-2  " name="add_expense" value="Proceed F10" tabindex="12" disabled>
			    <input type="submit" value="Submit And Add Another One F6" name="add-expense-another" class="btn btn-success1  col-sm-4" id="add-expense-another" tabindex="13">
			
			    <input type="button" id="add_expense_draft" class="btn btn-warning btn-large  col-sm-2" name="add_expense_draft" value="Expense Draft F7" tabindex="14">
			
			    <input type="reset"  class="btn btn-danger btn-large col-sm-2 " name="reset" id="Reset" value="Reset F5" tabindex="15">
			</div>
			
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
		<option value="<?php echo $stat['id'];?>" data-unit="<?php echo $stat['fld_unit'];?>"><?php echo $stat['name'];?></option>
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
<input type="hidden" id="countRows" value="2" />
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