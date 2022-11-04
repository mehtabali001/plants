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
                  <a href="<?= base_url();?>Others/add_partner" type="button" class="btn btn-primary btn-large"><i class="fa fa-shopping-cart"></i>&nbsp;New Partner</a>
                  <a href="<?= base_url();?>Others/manage_partners" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Partners</a>
                  <a href="<?= base_url();?>Others" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;New Others</a>
                  <a href="<?= base_url();?>Others/manage_others" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Other Parties</a>
                </div>
			</div>
			<!--<h4 class="page-title">Add Partner</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Others</a></li>-->
			<!--	<li class="breadcrumb-item active">Add Partner</li>-->
			<!--</ol>-->
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<form method="post" action="">
				    <input type="hidden" name="addPartner" value="1" />
				    <input type="hidden" name="head_account" value="202001" />
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
				<?php
							    $getHeadCodeData = $this->db->select('*')->from('tbl_coa')->where('head_code',202001)->get()->row();
        
                                $getHeadCodeForNew = $this->db->select('*,count(head_code) as hc')->from('tbl_coa')->where('parent_head_name',$getHeadCodeData->head_name)->get()->row();
                                
                                $nid  = $getHeadCodeForNew->hc;
                                $n =$nid + 1;
                                $n = sprintf('%03d', $n); 
                                $HeadCode = 202001 . $n;
							?>
				<div class="row">
					<div class="col-lg-6">
						<label class="mb-2">Other's Code <i class="text-danger">*</i></label>
						
						<input type="text" class="form-control" name="others_code" id="head_code" readonly  value="<?php echo $HeadCode; ?>" required tabindex="1" >            
					</div> 
					<div class="col-lg-6">
						<label class="mb-2">Name <i class="text-danger">*</i></label>
						
						<input type="text"  name="name" class="form-control" id="name" required tabindex="2" placeholder="e.g OGDCL" pattern=".*\S+.*">
					</div>
					<div class="col-lg-6">
						<label class="mb-2">Address <i class="text-danger">*</i></label>
						
						<input type="text" class="form-control"  name="address" id="Address" required placeholder="e.g OGDCL" pattern=".*\S+.*">
					</div>
					<div class="col-lg-6">
						<label class="mb-2">COA</label>
						
						<input type="text" class="form-control" id="fld_coa" placeholder="Liabilities & Owners Equity->Share Capital & Reserves->Capital Shares of The Partners" readonly>
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
						<label class="mb-2">Contact #</label>
						
						<input type="text" class="form-control"  name="contact" id="Contact" placeholder="e.g 051-1234567">
					</div>
					
					
					
				</div>
				<div class="row">
				    <div class="col-lg-12">
				        <div class="mt-3">
						<label class="mb-2"></label>
						<button type="submit" class="btn btn-successs">Proceed</button>
						</div>
				    </div>  
				</div>
				
				
				<!--</div>-->
				</form>
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