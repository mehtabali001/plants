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
    background: #506ee4;
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
                 <a href="<?= base_url();?>Emailrequest" type="button" class="btn btn-outline-primary"><i class="fas fa-sign-in-alt"></i>&nbsp;Balancesheet Cron</a>
                  <a href="<?= base_url();?>Emailrequest/cashflowRequest" type="button" class="btn btn-outline-primary"><i class="fas fa-sign-in-alt"></i>&nbsp;Cashflow Cron</a>
                  <a href="<?= base_url();?>Emailrequest/trialbalance" type="button" class="btn btn-outline-primary"><i class="fas fa-sign-in-alt"></i>&nbsp;Trialbalance Cron</a>
                  <a href="<?= base_url();?>Emailrequest/income_statement" type="button" class="btn btn-primary btn-large"><i class="fas fa-sign-in-alt"></i>&nbsp;Incomestatment Cron</a>
                </div>
			</div>
			<!--<h4 class="page-title">Send Income Statement Request</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Email Request</a></li>-->
			<!--	<li class="breadcrumb-item active">Income Statement Request</li>-->
			<!--</ol>-->
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card" style="overflow:auto;">
			<div class="card-body">
			    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
                <div id="pageloader">
                   <!--<img src="http://cdnjs.cloudflare.com/ajax/libs/semantic-ui/0.16.1/images/loader-large.gif" alt="processing..." />-->
                   <img src="<?= base_url('assets/uploads/ajax_loading.gif');?>" alt="processing..." >
                </div>
				<form method="post" id="myform" action="<?= base_url('Emailrequest/sendincomestatementrequest');?>" enctype="multipart/form-data">
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
				<?php
				 $qry = $this->db->query("SELECT * FROM tbl_incomestatement_emailrequest");
				 if($qry->num_rows() > 0){
				 $qry2 = $this->db->query("SELECT * FROM tbl_incomestatement_emailrequest where id = 1")->row();
				 }
				?>
				<div class="col-lg-12">
					<div class="mt-3">
						<label class="mb-2">Send To <i class="text-danger">*</i><i style="font-size:10px;">(Below listed emails will receive income statement daily.)</i></label>
					    <input type="text" name="send_to" data-role="tagsinput" placeholder="Add Emails" class="form-control" required tabindex="1" value="<? if($qry->num_rows() > 0){ echo $qry2->send_to; } ?>" />
					</div>
				</div> 
				<div class="col-lg-6">
				    <div class="mt-3">
                        <label for="example-time-input" class="mb-2">Cron Time<i style="font-size:10px;">(Listed emails will receive income statement daily on below mentioned time)</i></label>
                        <input class="form-control" name="sending_time" type="time" id="example-time-input" value="<? if($qry->num_rows() > 0){ echo $qry2->sending_time; } ?>" required>
                    </div>
				</div>
				<div class="col-lg-6">
                   <div class="row">
                      <div class="col-md-3" style="margin-top: 3%;">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="customRadio3" name="status" class="custom-control-input" value="1" <? if($qry->num_rows() > 0 && $qry2->status == 1){ echo "checked"; } ?>>
                            <label class="custom-control-label" for="customRadio3">Active</label>
                        </div><br>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="customRadio4" name="status" class="custom-control-input" value="2" <? if($qry->num_rows() > 0 && $qry2->status == 2){ echo "checked"; } ?>>
                            <label class="custom-control-label" for="customRadio4">In-active</label>
                        </div>
                        </div>
                        <div class="col-md-6" style="margin-top: 8%;">
                        <button type="submit" class="btn btn-successs">Proceed</button>
						<button type="submit" name="add-email-now" class="btn btn-gradient-primary">Email Immediately</button>
						</div>
                    </div>
                </div>
                <div class="col-lg-12">
                  <div class="mt-3">
				     <p class="link" style="color:red;">Note : Subject for Email , Title and Email body is created in Email Template section. For changes Please visit "<a href="https://zstar.mktechsol.com/Settings/editemail/11">https://zstar.mktechsol.com/Settings/editemail/11</a>"<br>If you want to in active this cron, please mark in active and proceed it to update.</p>
				    </div>
                </div>
				</div>
				</form>
				<br><br>
				<table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                <tr>
					<th>#</th>
					<th>Cron Date</th>
                    <th>Send To</th>
                    <th>Cron Time</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
				<?php 
				 //$qryy = $this->db->query("SELECT * FROM tbl_stocks_emailrequest")->row_array();
				 $qryy = $this->Base_model->getAll('tbl_incomestatement_emailrequest');
				 if($qryy){
					$i=1;
					foreach($qryy as $q){
				?>
					<tr>
						<td><?= $i;?></td>
						<td><?= date('d-m-Y H:i',strtotime($q['date_created']));?></td>
						<td><?= $q['send_to'];?></td>
						<td><?= date('h:i A',strtotime($q['sending_time']));?></td>
						<td>
						<? 
						if($q['status'] == 1){
						   echo "Active";
						}else{
						   echo "In-active"; 
						}
						?>
						</td>
					</tr>
				<?php $i++; } }else{ ?>
				    <tr>
						<td colspan="5" style="text-align:center:color:red;">Sorry No Record found!</td>
						<td style="display:none;"></td>
						<td style="display:none;"></td>
						<td style="display:none;"></td>
						<td style="display:none;"></td>
					</tr>
				<?php } ?>
                </tbody>
            </table>
			</div>
			</div><!--end card-body-->
		</div><!--end card-->                                       
	</div><!--end col-->
</div>
</div><!--container-->
<script>
$(document).ready(function(){
  $("#myform").on("submit", function(){
    $("#pageloader").fadeIn();
  });//submit
});//document ready
</script>
