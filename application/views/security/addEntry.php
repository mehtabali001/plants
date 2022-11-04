<style>
.custom-control {
    display: inline-block !important;
    top: 20px;
}
.bootstrap-tagsinput {
    width:100%;
    /*height: calc(1.8em + 0.75rem + 2px);*/
    padding: 8px 6px;
}
.bootstrap-tagsinput .tag {
    background: blue;
    padding: 5px;
    border-radius: 5px;
    margin-bottom: 5px;
    float: left;
}
#pageloader
{
  background: rgba( 255, 255, 255, 0.8 );
  display: none;
  height: 100%;
  position: fixed;
  width: 100%;
  z-index: 9999;
}

#pageloader img
{
  left: 35%;
  margin-left: -32px;
  margin-top: -32px;
  position: absolute;
  top: 30%;
}
.link a:hover{
    color:blue;
}
.link a{
    color:red;
}
</style>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-12" style="margin-bottom:2%;">
		<div class="page-title-box">
			<div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Entries" type="button" class="btn btn-primary btn-large"><i class="fas fa-sign-in-alt"></i>&nbsp;Add Entry</a>
                  <a href="<?= base_url();?>Entries/manage_entries" type="button" class="btn btn-outline-primary"><i class="fas fa-sign-in-alt"></i>&nbsp;Manage Entries</a>
                </div>
			</div>
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card" style="overflow:auto;">
			<div class="card-body">
			    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
                <div id="pageloader">
                   <img src="<?= base_url('assets/uploads/ajax_loading.gif');?>" alt="processing..." >
                </div>
				<form method="post" id="myform" action="<?= base_url('Entries/add');?>" enctype="multipart/form-data">
				<div class="row">
				<div class="col-lg-12">
				<?php 
				$error_message = $this->session->userdata('error_message');
				if (isset($error_message)) {
				?>
					<div class="alert alert-danger">
						<?php echo $error_message ?>                    
					</div>
				<?php
					$this->session->unset_userdata('error_message');
				} ?>
				<?php $success_message = $this->session->userdata('success_message');
				  if(isset($success_message)){
				?>
					<div class="alert alert-success">
						<?php echo $success_message ?>                    
					</div>
				<?php
					$this->session->unset_userdata('success_message');
				} ?>
				</div>
			
				<div class="col-lg-12">
				    <div class="mt-3">
					   <label class="mb-2">Date <i class="text-danger">*</i></label>                                     
					   <input type="text" class="form-control datepicker" name="entry_date" id="entry_date" value="<?= date('d/m/Y')?>" required>	
                    </div>
                    <div class="mt-3">
						<label class="mb-2">Vehicle <i class="text-danger">*</i></label>
						<select class="select2 form-control mb-3 custom-select" id="fld_vehicle" name="fld_vehicle" required="required">
							<option value="">Select Vehicle</option>
							<?php
								if($vehicles){
								foreach($vehicles as $veh){
							?>
							<option value="<?= $veh['fld_id'];?>" data_driver="<?= $veh['fld_dname1'];?>"><?= $veh['fld_vehicle_number'];?></option>
							<?php } } ?>
						</select>
					</div>
					<div class="mt-3">
						<label class="mb-2">Driver <i class="text-danger">*</i></label>
					    <input type="text" name="driver" id="driver_name" placeholder="Driver Name" class="form-control" required />
					</div>
				</div> 
				<div class="col-lg-6">
				    <div class="mt-3">
                        <label for="in-time-input" class="mb-2">In Time <i class="text-danger">*</i></label>
                        <input class="form-control" name="in_time" type="time" id="in-time-input" required>
                    </div>
				</div>
				<div class="col-lg-6">
				    <div class="mt-3">
                        <label for="out-time-input" class="mb-2">Out Time </label>
                        <input class="form-control" name="out_time" type="time" id="out-time-input">
                    </div>
				</div>
				<div class="col-lg-6">
                  <div class="row">
                    <div class="col-md-6" style="margin-top: 8%;">
                      <button type="submit" class="btn btn-successs">Proceed</button>
					</div>
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
<script>
$(document).ready(function(){
  $("#myform").on("submit", function(){
    $("#pageloader").fadeIn();
  });//submit
});//document ready
</script>