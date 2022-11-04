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
	<div class="col-sm-12" style="margin-bottom:2%;">
		<div class="page-title-box">
			<div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Others/add_partner" type="button" class="btn btn-outline-primary "><i class="fas fa-comments"></i>&nbsp;New Complaint</a>
                  <a href="<?= base_url();?>Complaints/my_complaints" type="button" class="btn btn-outline-primary"><i class="fa fa-paper-plane" aria-hidden="true"></i>&nbsp;My Complaints</a>
                  <a href="<?= base_url();?>Complaints/assigned_complaints" type="button" class="btn btn-primary btn-large"><i class='fas fa-box-open'></i>&nbsp;Assigned Complaints</a>
                  <a href="<?= base_url();?>" type="button" class="btn btn-outline-primary"><i class="fas fa-tachometer-alt"></i>&nbsp;Dashboard</a>
                </div>
			</div>
			
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<form method="post" id="resolvecomplaintform" >
				
				<div id="addcomplaint">
				<div class="row">
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
				</div>
				<h4>Complainer Details</h4>
				    <hr>
				<div class="row">
				    <div class="col-sm-6">
    					<div class="form-group row">
    						<label for="supplier_sss" class="col-sm-4 col-form-label">Complainer Name <i class="text-danger"></i>
    						</label>
    						<div class="col-sm-8">
    							<input type="text" class="form-control" name="complain_subject" id="complain_subject"   value="<?= $complaint['fld_username']?>" readonly placeholder="John Doe" >
    						</div>
    							
    					</div> 
    				</div>
    				<div class="col-sm-6">
    					<div class="form-group row">
    						<label for="supplier_sss" class="col-sm-4 col-form-label">Designation <i class="text-danger"></i>
    						</label>
    						<div class="col-sm-8">
    							<input type="text" class="form-control" name="complain_subject" id="complain_subject"   value="<?= $complaint['role_name']?>" readonly placeholder="Manager" >
    						</div>
    							
    					</div> 
    				</div>
    				<div class="col-sm-6">
    					<div class="form-group row">
    						<label for="supplier_sss" class="col-sm-4 col-form-label">Phone Number <i class="text-danger"></i>
    						</label>
    						<div class="col-sm-8">
    							<input type="text" class="form-control" name="complain_subject" id="complain_subject"   value="<?= $complaint['fld_mobile_number']?>" readonly placeholder="+923131234567" >
    						</div>
    							
    					</div> 
    				</div>
    				<div class="col-sm-6">
    					<div class="form-group row">
    						<label for="supplier_sss" class="col-sm-4 col-form-label">Email <i class="text-danger"></i>
    						</label>
    						<div class="col-sm-8">
    							<input type="text" class="form-control" name="complain_subject" id="complain_subject"   value="<?= $complaint['fld_email']?>" readonly placeholder="abc@mail.com" >
    						</div>
    							
    					</div> 
    				</div>
				</div>
				<h4>Complaint Details</h4>
				    <hr>
				<div class="row">
				    <div class="col-sm-4">
    					<div class="form-group row">
    						<label for="" class="col-sm-4 col-form-label" style="float:left;text-align: left;">Complaint ID<i class="text-danger">*</i>
    						</label>
    						<div class="col-sm-8">
    							<input type="text" class="form-control" name="complain_id" id="complain_id"   value="<?= $complaint['fld_complain_id']?>" required tabindex="1" readonly placeholder="CI-10001">
    						</div>
    							
    					</div> 
    				</div>
    				<div class="col-sm-3">
    					<div class="form-group row">
    						<label for="supplier_sss" class="col-sm-4 col-form-label" style="float:left;text-align: left;">Subject <i class="text-danger"></i>
    						</label>
    						<div class="col-sm-8">
    							<input type="text" class="form-control" name="complain_subject" id="complain_subject"   value="<?= $complaint['fld_complain_subject']?>" readonly  tabindex="1" >
    						</div>
    							
    					</div> 
    				</div>

				 <div class="col-sm-5">
					<div class="form-group row">
						<label for="supplier_sss" class="col-sm-4 col-form-label" style="float:left;text-align: left;">Category <i class="text-danger"></i>
						</label>
						<div class="col-sm-8">
							<select class="form-control" name="comp_category" id="comp_category" disabled tabindex="2" >
								<option value="">Select Category</option>
								<?php foreach($comp_category as $categ){?>
									<option value="<?= $categ['id'];?>" <?= ($complaint['fld_category'] == $categ['id'])?"selected":"";?>><?= $categ['category_name'];?></option>
								<?php }?>
							</select>
							
						</div>
					</div> 
				</div>
                
				
				<div class="col-sm-12">
					<div class="form-group row">
						<label for="supplier_sss" class="col-sm-1 col-form-label" style="float:left;text-align: left;">Details<i class="text-danger"></i>
						</label>
						<div class="col-sm-11">
							<textarea readonly class="form-control" rows="5" name="complain_description" id="complain_description"  tabindex="3" ><?= $complaint['fld_description']?></textarea>
						</div>
							
					</div> 
				</div>
				<div class="col-sm-12">
					<div class="form-group row">
						<label for="supplier_sss" class="col-sm-1 col-form-label" style="float:left;text-align: left;">To <i class="text-danger"></i>
						</label>
						<div class="col-sm-11">
							<select class=" form-control mb-3 custom-select" name="complain_to" disabled id="complain_to" tabindex="4" >
								<option value="">Select User</option>
								<?php foreach($users as $u){?>
									<option value="<?= $u['fld_id'];?>" <?= ($complaint['fld_complaint_to'] == $u['fld_id'])?"selected":"";?>><?= $u['fld_username'];?></option>
								<?php }?>
							</select>
							
						</div>
						
					</div> 
				</div>

                </div>
				
				<input type="hidden" name="edit_id" value="<?= $complaint['fld_id']?>"/>
			
				<div class="col-lg-12" style="display:<?= ($complaint['fld_status'] == 1)?"none":"";?>">
					<div class="mt-3">
						<label class="mb-2"></label>
						<button type="submit" name="submit" class="btn btn-gradient-primary">Submit Reply</button>
						
					</div>
				</div>
				
				</div>
				</form>
				
				</div>
				
				
				
			</div>
			</div> <!-- end card-body -->
		</div> <!-- end card -->                                       
	</div> <!-- end col -->
</div>
</div><!-- container -->
<script>
    function updateValue(){
       var p1 = $("#fld_head_account").find(':selected').attr('data-parent1');
       var p0 = $("#fld_head_account").find(':selected').attr('data-parent0'); 
       var headCode = $("#fld_head_account").find(':selected').attr('data-headcode'); 
       $("#head_code").val(headCode)
       var final ="COA->"+ p0 +"->"+ p1;
       $("#fld_coa").val(final);
    }
</script>