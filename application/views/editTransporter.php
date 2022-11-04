<div class="container-fluid">
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right" style="margin-bottom:15px;">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Common/addTransporter" type="button" class="btn btn-outline-primary"><i class="fas fa-bus"></i>&nbsp;New Transport/Bowser</a>
                  <a href="<?= base_url();?>Common/manage_Transporter" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Transport/Bowser</a>
                  <a href="<?= base_url();?>Navigations/createIntNav" type="button" class="btn btn-outline-primary"><i class='fas fa-rocket'></i>&nbsp;New Navigation</a>
                  <a href="<?= base_url();?>Navigations/navigationReport" type="button" class="btn btn-outline-primary"><i class='fa fa-bar-chart'></i>&nbsp;Navigations Report</a>
                </div>
			</div>
			<!--<h4 class="page-title">Edit Transport/Bowser</h4>-->
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<form method="post" action="<?= base_url('Common/editTransprocess');?>" id="edit_supplier">
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
				} ?>
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
				
				<div class="col-lg-6">
                    <div class="mt-3">
						<label class="mb-2">Vehicle No. <i class="text-danger">*</i></label>
						<input type="text" class="form-control" name="fld_vehicle_number" placeholder="e.g V-001" id="fld_vehicle_number" value="<?= $transporter['fld_vehicle_number'];?>" required>
					</div>
					<div class="mt-3">
						<label class="mb-2">Driver one Name <i class="text-danger">*</i></label>
						<input type="text" class="form-control" name="fld_dname1" placeholder="e.g Aslam khan" value="<?= $transporter['fld_dname1'];?>" id="fld_dname1" required>
					</div>
					<div class="mt-3">
						<label class="mb-2">Driver one CNIC </label>
						<input type="text" class="form-control" name="fld_dcnic1" placeholder="e.g 00000-0000000-0" value="<?= $transporter['fld_dcnic1'];?>" id="fld_dcnic1">
					</div> 
					<div class="mt-3">
						<label class="mb-2">Driver one Mobile <i class="text-danger">*</i></label>
						<input type="text" class="form-control" name="fld_dmobile1" placeholder="e.g 0000-0000000" value="<?= $transporter['fld_dmobile1'];?>" id="fld_dmobile1" required>
					</div> 
					<div class="mt-3">
						<label class="mb-2">Driver one Address </label>
						<input type="text" class="form-control" name="fld_daddress1" placeholder="e.g Rawalpindi, Pakistan" value="<?= $transporter['fld_daddress1'];?>" id="fld_daddress1">
					</div> 
					<div class="mt-3">
						<label class="mb-2">Driver one License </label>
						<input type="text" class="form-control" name="fld_dlicense1" placeholder="e.g ZP001234" value="<?= $transporter['fld_dlicense1'];?>" id="fld_dlicense1">
					</div> 
					<div class="mt-3">
						<label class="mb-2">Driver one License Issue</label>
						<input type="text" class="form-control datepicker" name="fld_dlicense_issue1" value="<?= date('d/m/Y', strtotime($transporter['fld_dlicense_issue1']));?>" id="fld_dlicense_issue1">
					</div> 
					<div class="mt-3">
						<label class="mb-2">Driver one License Expire</label>
						<input type="text" class="form-control datepicker" name="fld_dlicense_expire1" value="<?= date('d/m/Y', strtotime($transporter['fld_dlicense_expire1']));?>"  id="fld_dlicense_expire1">
					</div> 
					<div class="mt-3">
						<label class="mb-2">Vehicle (Owned By) </label>
						<select class="select2 form-control custom-select" name="fld_vehicle_type" id="fld_vehicle_type" required>
							<option value="1" selected>Self</option>
							<option value="2">Other</option>
						</select>
					</div>
				    <div class="mt-3">
						<label class="mb-2">COA</label>
						<input type="text" class="form-control" id="fld_coa" value="COA->Income->Other Income->Bowzer Income" readonly>
					</div>
				</div> 
				
				<div class="col-lg-6">
				    <div class="mt-3">
						<label class="mb-2">Owner Name </label>
						<input type="text" class="form-control" placeholder="e.g Aslam khan" value="<?= $transporter['fld_owner_name'];?>"  name="fld_owner_name" id="fld_owner_name">
					</div>
					
				<div class="mt-3">
						<label class="mb-2">Driver two Name </label>
						<input type="text" class="form-control" name="fld_dname2" value="<?= $transporter['fld_dname2'];?>" placeholder="e.g Aslam khan" id="fld_dname2" >
					</div>
					<div class="mt-3">
						<label class="mb-2">Driver two CNIC </label>
						<input type="text" class="form-control" name="fld_dcnic2" value="<?= $transporter['fld_dcnic2'];?>" placeholder="e.g 00000-0000000-0" id="fld_dcnic2" >
					</div> 
					<div class="mt-3">
						<label class="mb-2">Driver two Mobile </label>
						<input type="text" class="form-control" name="fld_dmobile2" value="<?= $transporter['fld_dmobile2'];?>" placeholder="e.g 0000-0000000" id="fld_dmobile2" >
					</div> 
					<div class="mt-3">
						<label class="mb-2">Driver two Address </label>
						<input type="text" class="form-control" name="fld_daddress2" value="<?= $transporter['fld_daddress2'];?>" placeholder="e.g Rawalpindi, Pakistan" id="fld_daddress2" >
					</div> 
					<div class="mt-3">
						<label class="mb-2">Driver two License </label>
						<input type="text" class="form-control" name="fld_dlicense2" value="<?= $transporter['fld_dlicense2'];?>" placeholder="e.g ZP001234" id="fld_dlicense2" >
					</div> 
					<div class="mt-3">
						<label class="mb-2">Driver two License Issue </label>
						<input type="text" class="form-control datepicker" value="<?= date('d/m/Y', strtotime($transporter['fld_dlicense_issue2']));?>" name="fld_dlicense_issue2" id="fld_dlicense_issue2" >
					</div> 
					<div class="mt-3">
						<label class="mb-2">Driver two License Expire </label>
						<input type="text" class="form-control datepicker" value="<?= date('d/m/Y', strtotime($transporter['fld_dlicense_expire2']));?>" name="fld_dlicense_expire2"  id="fld_dlicense_expire2" >
					</div> 
					<div class="mt-3">
						<label class="mb-2">Area Cover</label>
						<input type="text" class="form-control" value="<?= $transporter['fld_area'];?>"  name="fld_area" placeholder="e.g 116 square miles.." id="fld_area" >
					</div>
				</div> 
				
				<div class="col-lg-12">
					<div class="mt-3">
						<label class="mb-2"></label>
						<button type="submit" class="col-sm-2 btn btn-successs">Update</button>
						<input type="hidden" name="transporter_id" value="<?= $transporter['fld_id']?>"/>
					</div>
				</div>
				</div>
				</form>
			</div>
			</div> <!-- end card-body -->
		</div> <!-- end card -->                                       
	</div> <!-- end col -->
</div>
</div><!-- container -->