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
.box{
        display: none;
}
</style>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Common/expense_type" type="button" class="btn btn-primary btn-large"><i class="fa fa-shopping-cart"></i>&nbsp;Add Expense Type</a>
                  <a href="<?= base_url();?>Common/manage_Expensetypes" type="button" class="btn btn-outline-primary"><i class="fa fa-vcard"></i>&nbsp;Manage Expense Types</a>
                </div>
			</div>
			<h4 class="page-title">Add Expense Type</h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="javascript:void(0);">Expenses</a></li>
				<li class="breadcrumb-item active">Expense Type</li>
			</ol>
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
	<form id="addExpense" method="post" action="<?= base_url('Common/addexpenseType');?>">
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
		<h4 class="form-section"><i class="icon-eye6"></i>Expense Type</h4>
	</div><hr>
	
	<div class="row">
        
        <div class="col-lg-12">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label" style="text-align:left;">Expense Type<i class="text-danger">*</i></label>
                <div class="col-sm-9">
                    <select class="select2 form-control mb-3 custom-select exptype" id="expense_type" name="expense_type" required>
                        <option value="">--Select Type--</option>
                        <option value="1">Office Expense</option>
                        <option value="2">Mess Expense</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="col-lg-12 1 box">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label" style="text-align:left;">Office Exp:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="expense_value1" placeholder="Add.." id="expense_value">
                </div>
            </div>
        </div>
        
        <div class="col-lg-12 2 box">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label" style="text-align:left;">Mess Exp:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="expense_value2" placeholder="Add.." id="expense_value">
                </div>
            </div>
        </div>
	</div>

	<div class="col-lg-12">
		<div class="mt-3">
			<label class="mb-2"></label>
			<input type="submit" id="add_expense_type" class="btn btn-gradient-primary" name="add_expense_type" value="Submit">
		</div>
	</div>
	</form>
	</div>
	</div> <!-- end card-body -->
	</div> <!-- end card -->                                       
	</div> <!-- end col -->
</div><!-- container -->