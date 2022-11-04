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
                  <a href="<?= base_url();?>Others/add_partner" type="button" class="btn btn-primary btn-large"><i class="fas fa-comments"></i>&nbsp;New Complaint</a>
                  <a href="<?= base_url();?>Complaints/my_complaints" type="button" class="btn btn-outline-primary"><i class="fa fa-paper-plane" aria-hidden="true"></i>&nbsp;My Complaints</a>
                  <a href="<?= base_url();?>Complaints/assigned_complaints" type="button" class="btn btn-outline-primary"><i class='fas fa-box-open'></i>&nbsp;Assigned Complaints</a>
                  <a href="<?= base_url();?>" type="button" class="btn btn-outline-primary"><i class="fas fa-tachometer-alt"></i>&nbsp;Dashboard</a>
                </div>
			</div>
			<!--<h4 class="page-title">Add Complaint</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Complaint</a></li>-->
			<!--	<li class="breadcrumb-item active">Add Complaint</li>-->
			<!--</ol>-->
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body" >
				<form method="post" id="addcomplaintform">
				
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
				<div class="row">
				    <div class='row' style='width:100%;'><img src='"+base_url+"assets/uploads/ajax_loading.gif' style='margin:auto; visibility: hidden;'></div>
				    <div class="col-sm-4">
    					<div class="form-group row">
    						<label for="" class="col-sm-4 col-form-label" style="float:left;text-align: left;">Complaint ID<i class="text-danger">*</i>
    						</label>
    						<div class="col-sm-8">
    							<input type="text" class="form-control" name="complain_id" id="complain_id"   value="<?= $maxid;?>" required tabindex="1" readonly placeholder="CI-10001">
    						</div>
    							
    					</div> 
    				</div>
				<div class="col-sm-3">
					<div class="form-group row">
						<label for="" class="col-sm-4 col-form-label" style="float:left;text-align: left;">Subject <i class="text-danger">*</i>
						</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="complain_subject" id="complain_subject"   value="" required tabindex="1" placeholder="Repair Machine">
						</div>
							
					</div> 
				</div>

				 <div class="col-sm-5">
					<div class="form-group row">
						<label for="" class="col-sm-3 col-form-label" style="float:left;text-align: left;">Category <i class="text-danger">*</i>
						</label>
						<div class="col-sm-7">
							<select class="select2 form-control mb-3 custom-select" name="comp_category" id="comp_category" tabindex="2" required>
								<option value="">Select Category</option>
								<?php foreach($comp_category as $categ){?>
									<option value="<?= $categ['id'];?>"><?= $categ['category_name'];?></option>
								<?php }?>
							</select>
							
						</div>
						<div class="col-sm-2">
							<a class="btn btn-success" onclick="complaint_function('categorydiv')" title="Add New Supplier" href="javascript:;"><i class="fa fa-user-plus"></i></a>
						</div>
					</div> 
				</div>
    <!--            </div>-->
				<!--<div class="row">-->
				<div class="col-sm-12">
					<div class="form-group row">
						<label for="" class="col-sm-1 col-form-label" style="float:left;text-align: left;">Details 
						</label>
						<div class="col-sm-11">
							<textarea class="form-control" rows="5" name="complain_description" id="complain_description"   tabindex="3" placeholder="Please repair the machine ...."></textarea>
						</div>
							
					</div> 
				</div>
				 <div class="col-sm-12">
					<div class="form-group row">
						<label for="" class="col-sm-1 col-form-label"  style="float:left;text-align: left;">To <i class="text-danger">*</i>
						</label>
						<div class="col-sm-11">
							<select class="select2 form-control mb-3 custom-select" name="complain_to" id="complain_to" tabindex="4" required>
								<option value="">Select User</option>
								<?php foreach($users as $u){
								$role_name=$this->db->query("SELECT * FROM tbl_roles where role_id ='".$u['fld_role']."'")->row_array();
								?>
									<option value="<?= $u['fld_id'];?>"><?= $u['fld_username'];?><?= (@$role_name['role_name'] != "")?" -- ".$role_name['role_name']:"";?></option>
								<?php }?>
							</select>
							
						</div>
						
					</div> 
				</div>
    <!--            </div>-->
				<!--<div class="row">-->
				

                </div>
				
				
				<div class="row">
				<div class="col-sm-6">
					<div class="mt-3">
						<label class="mb-2"></label>
						<button type="submit" class="btn btn-successs" >Proceed</button>
					</div>
				</div>
				</div>
				
				</div>
				</form>
				<div class="row" id="categorydiv" style="display:none;">
				<div class="col-lg-12">
					<h4 class="form-section"><i class="icon-eye6"></i>Add Category</h4>
				</div>
				<div class="col-lg-12" style="padding:0px;">
					<hr>
				</div>
				<form method="post" id="addComplaintCat" style="width: 100%;">
				<div class="row">
				<div class="col-lg-6">
					<div class="mt-3">
						<label class="mb-2">Category Name <i class="text-danger">*</i></label>
						<input type="text" class="form-control" placeholder="" name="category_name" tabindex="1" id="category_name" required>
					</div>
				</div>	
				
				<div class="col-lg-12">
					<div class="mt-3">
						<label class="mb-2"></label>
						<button type="submit" name="submit" class="btn btn-gradient-primary">Submit</button>
						<button type="button" onclick="complaint_function('addcomplaint')" class="btn btn-gradient-danger">Cancel</button>
					</div>
				</div>
				
				</div>
				</form>
				</div>
				</div>
				
				
				
			</div>
			</div> <!-- end card-body -->
		</div> <!-- end card -->                                       

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