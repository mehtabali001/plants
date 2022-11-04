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
</style>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right">
    			<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Vouchers/chequepaidvoucher" type="button" class="btn btn-primary btn-large"><i class="fa fa-shopping-cart"></i>&nbsp;Cheque Paid Voucher</a>
                  <a href="<?= base_url();?>Vouchers/cashpayementvoucher" type="button" class="btn btn-outline-primary"><i class="fa fa-vcard"></i>&nbsp;Cash Payment Voucher</a>
                  <a href="<?= base_url();?>Vouchers/journalvoucher" type="button" class="btn btn-outline-primary"><i class="fa fa-files-o"></i>&nbsp;Journal Voucher</a>
                  <a href="<?= base_url();?>Accounts/balancesheet" type="button" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;COA</a>
                </div>
			</div>
			<h4 class="page-title">Accounts</h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="javascript:void(0);">Accounts</a></li>
				<li class="breadcrumb-item active">Cheque Paid Voucher</li>
			</ol>
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<form method="post" action="">
				<div class="col-lg-12">
				<?php $error_message = $this->session->userdata('error_message');
				if (isset($error_message)) {
					?>
					<div class="alert alert-danger">
						
						<?php echo $error_message ?>                    
					</div>
					<?php
					$this->session->unset_userdata('error_message');
				}?>
				<?php $success_message = $this->session->userdata('success_message');
				if (isset($success_message)) {
					?>
					<div class="alert alert-success">
						
						<?php echo $success_message ?>                    
					</div>
					<?php
					$this->session->unset_userdata('success_message');
				}?>
				</div>
				<h4 class="page-title">Cheque Paid Voucher</h4>
				<div class="col-lg-12">
				    
				    <div class="row">
				        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="" class="col-sm-4 col-form-label">Voucher Code <i class="text-danger"></i>
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" tabindex="6" class="form-control" placeholder="e.g 156925"  id="fld_voucher_code" name="fld_voucher_code" >
									
                                </div>
                            </div>
                        </div>
    				    <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="date" class="col-sm-4 col-form-label">Issue Date <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-6">
    							<input type="text" required="" tabindex="2" class="form-control datepicker" name="fld_issue_date" id="fld_issue_date"  >
                                </div>
                            </div>
                        </div>
				    </div>
				</div>
				<hr>
				<div class="col-lg-12">
				    <h4 class="page-title">Issued To</h4>
				    <div class="row">
				        
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="" class="col-sm-4 col-form-label">Party/Acc <i class="text-danger"></i>
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" tabindex="6" class="form-control" placeholder="e.g 156925"  id="fld_account_name" name="fld_account_name" >
									
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="" class="col-sm-4 col-form-label">Balance <i class="text-danger"></i>
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" tabindex="6" class="form-control" placeholder="e.g 156925"  id="fld_balance" name="fld_balance" >
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="" class="col-sm-4 col-form-label">Bank Name<i class="text-danger"></i>
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" tabindex="6" class="form-control" placeholder="e.g 156925"  id="fld_bank_name" name="fld_bank_name" >
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="" class="col-sm-4 col-form-label">Cheque#<i class="text-danger"></i>
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" tabindex="6" class="form-control" placeholder="e.g 156925"  id="fld_cheque_no" name="fld_cheque_no" >
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="date" class="col-sm-4 col-form-label">Cheque Date <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-6">
    							<input type="text" required="" tabindex="2" class="form-control datepicker" name="fld_cheque_date" id="fld_cheque_date"  >
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="date" class="col-sm-4 col-form-label">Slip <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-6">
    							<input type="text" class="form-control " name="fld_slip" id="fld_slip"  >
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="date" class="col-sm-4 col-form-label">Status<i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-6">
    							<input type="text" class="form-control " name="fld_status" id="fld_status"  >
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="date" class="col-sm-4 col-form-label">Amount(PKR)<i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-6">
    							<input type="text"  class="form-control" name="fld_amount" id="fld_amount"  >
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="date" class="col-sm-4 col-form-label">Remarks<i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-6">
    							<input type="text"  class="form-control" name="fld_remarks" id="fld_remarks"  >
                                </div>
                            </div>
                        </div>
				    </div>
				</div>
				<hr>
				<h4 class="page-title">Issued From</h4>
				<div class="col-lg-12">
				    <div class="row">
				        	
				<div class="col-sm-6">
                    <div class="form-group row">
                        <label for="date" class="col-sm-4 col-form-label">Bank Name<i class="text-danger">*</i>
                        </label>
                        <div class="col-sm-6">
						<input type="text"  class="form-control" name="fld_bank_name" id="fld_bank_name"  >
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group row">
                        <label for="date" class="col-sm-4 col-form-label">Mature Date <i class="text-danger">*</i>
                        </label>
                        <div class="col-sm-6">
						<input type="text" required="" tabindex="2" class="form-control datepicker" name="fld_mature_date" id="fld_cheque_date"  >
                        </div>
                    </div>
                </div>
				    </div>
				</div>
			
                
				<div class="col-lg-6">
					<div class="mt-3">
						<label class="mb-2"></label>
						<button type="submit" class="btn btn-gradient-primary">Submit</button>
					</div>
				</div>
				</form>
			</div>
			</div> <!-- end card-body -->
		</div> <!-- end card -->                                       
	</div> <!-- end col -->
                   

</div><!-- container -->

