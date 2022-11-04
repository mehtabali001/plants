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
	<div class="col-sm-12" style="margin-bottom:1%;">
		<div class="page-title-box">
			<div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Others/add_partner" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;New Partner</a>
                  <a href="<?= base_url();?>Others/manage_partners" type="button" class="btn btn-outline-primary "><i class="fa fa-eye"></i>&nbsp;View Partners</a>
                  <a href="<?= base_url();?>Others" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;New Others</a>
                  <a href="<?= base_url();?>Others/manage_others" type="button" class="btn  btn-primary btn-large"><i class="fa fa-eye"></i>&nbsp;View Other Parties</a>
                </div>
			</div>
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<!--<div class="row">-->
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<form method="post" action="" id="edit_supplier">
				    <input type="hidden" name="editOther" value="1" />
				<!--<div class="row">-->
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
				
				<div class="row">
					<div class="col-lg-6">
						<label>Other's Code <i class="text-danger">*</i></label>
						
						<input type="text" class="form-control" name="others_code" id="head_code" readonly  value="<?php echo $edit_coa['head_code']; ?>" required tabindex="1" >            
					</div> 
					<div class="col-lg-6">
						<label>Name <i class="text-danger">*</i></label>
						
						<input type="text"  name="name" class="form-control" id="name" value="<?php echo $edit_coa['head_name']; ?>" required tabindex="2" placeholder="e.g OGDCL"  pattern=".*\S+.*">
					</div>

					<div class="col-lg-6">
						<label>Address <i class="text-danger">*</i></label>
						
						<input type="text" class="form-control"  name="address" id="Address" value="<?php echo $edit_coa['address']; ?>" tabindex="3" required placeholder="e.g OGDCL"  pattern=".*\S+.*">
					</div>     
					<?php 
					
					 $parent_head_2 = $edit_coa['parent_head_name'];
					 $parent_head_1 = $this->db->query("SELECT * FROM tbl_coa where head_name='$parent_head_2'")->row()->parent_head_name;
					 $parent_head_0 = $this->db->query("SELECT * FROM tbl_coa where head_name='$parent_head_1'")->row()->parent_head_name;
					 ?>
					
					<div class="col-lg-6">
						<label class="mb-2">COA</label>
						
						<input type="text" class="form-control" tabindex="4" id="fld_coa" placeholder="<?php echo $parent_head_0; ?>-><?php echo $parent_head_1; ?>-><?php echo $parent_head_2; ?>" readonly>
					</div> 
					
					<div class="col-lg-12">
    					<div class= id="" style="float:right; margin-top:10px;">
                            <div class="custom-control custom-switch switch-secondary ">
                            <input type="checkbox" class="custom-control-input" id="customSwitchSecondary" name="moreinfo">
                            <label class="custom-control-label" for="customSwitchSecondary">Additional Info</label>
                        </div>
                        <i class="text-danger" id="phone"></i>
                        </div>
    				</div>
					                            
				</div> 
				<div id="moreInfo" class="row" style="display: none;">
					
					<div class="col-lg-6">
						<label>Contact #</label>
						
						<input type="text" class="form-control"  name="contact" value="<?php echo $edit_coa['contact']; ?>" tabindex="5" id="Contact" placeholder="e.g 051-1234567">
					</div>
				
					
					
				</div>
				<div class="row">
				<div class="col-lg-6">
					<div class="mt-3">
						<label class="mb-2"></label>
						<button type="submit" class="btn btn-successs" tabindex="6" disabled>Update</button>
					</div>
				</div>
				</div>
				
				<!--</div>-->
				</form>
			</div>
			</div> <!-- end card-body -->
		</div> <!-- end card -->                                       
	<!-- </div> end col -->


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