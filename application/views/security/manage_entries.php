<style>
#datatable_filter > label
{
	float: right;
}
.pagination
{
	float: right;
}
.dataTables_empty
{
	text-align: center;
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
	height: 36px;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #bac1dc;
    line-height: 28px;
    padding-top: 2px;
}
.sorting_1 p{
    text-align:center;
}
.dataTables_empty{
    color:red;
}
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

<div class="row">
	<div class="col-sm-12" style="margin-bottom:2%;">
		<div class="page-title-box">
			<div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Entries" type="button" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i>&nbsp;Add Entry</a>
                  <a href="<?= base_url();?>Entries/manage_entries" type="button" class="btn btn-outline-primary btn-large"><i class="fas fa-sign-in-alt"></i>&nbsp;Manage Entries</a>
                </div>
			</div>
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card" style="overflow:auto;">
			<div class="card-body">
			    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
       <!--         <div id="pageloader">-->
       <!--            <img src="<?//= base_url('assets/uploads/ajax_loading.gif');?>" alt="processing..." >-->
       <!--         </div>-->
			
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
            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            <thead>
            <tr>
                <th>#</th>
				<th>Date</th>
                <th>Vehicle</th>
                <th>Driver</th>
                <th>In Time</th>
                <th>Out Time</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody id="employee_data1">
            <?php 
              if($entries){
              $i=0;      
			  foreach($entries as $entry){
			  $i++;     
		      $vehicle = $this->Common_model->select_single_field('fld_vehicle_number','tbl_transporter', array('fld_id' => $entry['fld_vehicle']));
		      $addedby = $this->Common_model->select_single_field('fld_username','tbl_users', array('fld_id' => $entry['add_by']));
			?>    
            <tr>
                <td><?php echo $i; ?></td>
                <td>
                <?php 
					  echo '<span style="width: 90px; display: inline-block;">'.date("d-m-Y",strtotime(@$entry['entry_date'])).'</span>'.'<br>';
					  echo '<span style="width: 200px; display: inline-block;color: #21d0c0;">Add By: '.$addedby.'</span>'.'<br>';
					  if($entry['update_by'] != 0){
					         $updateby = $this->Common_model->select_single_field('fld_username','tbl_users', array('fld_id' => $entry['update_by']));
            				echo '<span style="width: 170px; display: inline-block;color:#506ee4; font-size:10px;">Updated On: '.date("d-m-Y,h:i A",strtotime(@$entry['modified_date'])).'</span>'."<br>";
            				echo '<span style="width: 170px; display: inline-block;color:#21d0c0; font-size:10px;">By: '.$updateby.'</span>'."<br>";
            			}
				?>
				</td>
                <td><?php echo $vehicle; ?></td>
                <td><?php echo $entry['driver']; ?></td>
                <td><?php echo $entry['in_time']; ?></td>
                <td><?php echo $entry['out_time']; ?></td>
                <td>
                           <? /*if(!empty($role_permissions) && in_array(7,$role_permissions)) { ?>
							    <a href="#" onclick="window.open('<?= base_url();?>purchase/print_single_purchase/<?= $purch['fld_id'];?>', 'Purchase Report', 'width=1210, height=842');">
							<i style="font-size:15px;cursor:pointer;" class="mdi mdi-printer" title="Print"></i></a>
							<? } ?>
							
							<? if(!empty($role_permissions) && in_array(6,$role_permissions)) { ?>
							<a href="#" onclick="window.open('<?= base_url();?>purchase/pdf_single_purchase/<?= $purch['fld_id'];?>', 'Purchase Report');">
							<i style="font-size:15px;cursor:pointer;" class="mdi mdi-file-pdf" title="Pdf"></i></a>
							<? } */?>
							
							<? //if(!empty($role_permissions) && in_array(3,$role_permissions)) { ?>
							<a href="<?= base_url('Entries/edit/'.$entry['fld_id'].'');?>">
							<i style="font-size:15px;cursor:pointer;" class="mdi mdi-square-edit-outline" title="Edit"></i></a>
							<? //} ?>
							
							<? /*if(!empty($role_permissions) && in_array(4,$role_permissions)) { ?>
							<a href="<?= base_url('Purchase/detail/'.$purch['fld_id'].'');?>"><i style="font-size:15px;cursor:pointer;" class="mdi mdi-eye-circle-outline" title="View"></i></a>
							<? } */ ?>
							
							<? //if(!empty($role_permissions) && in_array(5,$role_permissions)) { ?>
							<a data-toggle="modal" class="exampleModal" data-target="#exampleModal" data-content="<?php echo $entry['fld_id']; ?>" data-uri="<?= base_url('Entries/delete/'.$entry['fld_id']);?>">
		<i style="font-size:20px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i></a>
							<? //} ?>
                </td>
            </tr>
            <?php }}else{ ?>
            <tr>
				<td colspan="7" style="text-align:center;color:red;">Sorry no record found!</td>
				<td style="display:none;"></td>
				<td style="display:none;"></td>
				<td style="display:none;"></td>
				<td style="display:none;"></td>
				<td style="display:none;"></td>
				<td style="display:none;"></td>
			</tr>
			<? } ?>
            </tbody>
            </table>
            </div>
			</div>
			
<div class="modal fade bs-example-modal-center" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="box-shadow: 0 7px 14px 0 rgb(65 203 216 / 50%) !important;">
    <div class="modal-header">
        <h5 class="modal-title mt-0" id="exampleModalLabel">Entry Invoice</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form id="modal-form" action="<?= base_url('Entries/delete');?>" method="post">
    <div class="modal-body">
        <p>Are you sure you want to delete this record.</p>
    </div>
    <div class="modal-footer">
        
        <input type="hidden" id="entry_id" name="fld_id" />
        <button type="button" class="btn btn-gradient-danger waves-effect waves-light" data-dismiss="modal">Cancel</button>
        <button type="Submit" class="btn btn-gradient-purple waves-effect waves-light">Proceed to Delete</button>
        
    </div>
    </form>
    </div>
</div>
</div>
			
			</div> <!-- end card-body -->
		</div> <!-- end card -->                                       
	</div> <!-- end col -->
</div>

