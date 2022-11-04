<style>
.iconof {
    position: absolute;
    top: -8px;
    right: -8px; 
}
.icon-lg {
    height: 22px;
    width: 22px;
}
.chart-report-card .report-main-icon, .report-card .report-main-icon {
    width: 35px;
    height: 35px;
}
.font-11{
    font-size:11px;
}
.card-body {
    padding: 1rem;
}
.text-truncate {
    white-space: break-spaces;
}
.new-boxe{
    border-left: 1px solid #ffffff;
}
.boxe{
    text-align:center;
}

.text-mute {
    color: #ffffff !important;
    font-size: 13px;
}
.btc-price h3 {
    font-size: 18px;
    color: #ffffff;
    font-weight: 600;
}
.bold{
    font-weight:bold;
}
.tablex td{
    border-color: #000000;
    color:#000;
}
.tablex th{
    border-color: #000000;
    color:#000;
}
.tablex thead th {
    border-bottom: 1px solid #000 !important;
}
.log th{
    border-color: #fff;
    color:#fff;
}
.log thead th {
    border-bottom: 1px solid #fff !important;
}
.log td{
    padding: 0.25rem;
    color: #fff !important;
    border-color: #fff;
}
.chart-report-card .report-main-icon, .report-card .report-main-icon {
    width: 20px;
    height: 20px;
}
body.enlarge-menu .page-wrapper {
    min-height: auto !important;
}
/*modal*/
#modalOverlay {
			position: fixed;
			top: 0;
			left: 0;
			background: rgba(0, 0, 0, 0.5);
			z-index: 99999;
			height: 100%;
			width: 100%;
	}
.modalPopup {
			position: absolute;
			top: 45%;
			left: 50%;
			transform: translate(-50%, -50%);
			background: #fff;
			width: 50%;
			padding: 0 0 30px;
			-webkit-box-shadow: 0 2px 10px 3px rgba(0,0,0,.2);
			-moz-box-shadow: 0 2px 10px 3px rgba(0,0,0,.2);
			box-shadow: 0 2px 10px 3px rgba(0,0,0,.2);
	}
.modalContent {padding: 0 2em;}
.headerBar {
		width: 100%;
		background: #355e67 ;
		margin: 0;
	  text-align: center;
	}
.headerBar img {
		margin: 1em .7em;
	}
h1 {
  margin-bottom: .2em;
  font-size: 26px;
  text-transform: capitalize;
}
p {margin: .75em 0 1.5em;}
.buttonStyle {
		border: transparent;
		border-radius: 0;
		background: #6d6d6d;
		color: #eee !important;
		cursor: pointer;
		font-weight: bold;
		font-size: 14px;
		text-transform: uppercase;
		padding: 6px 25px;
		text-decoration: none;
		background: -moz-linear-gradient(top, #6d6d6d 0%, #1e1e1e 100%);
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#6d6d6d), color-stop(100%,#1e1e1e));
		background: -webkit-linear-gradient(top, #6d6d6d 0%,#1e1e1e 100%);
		background: -o-linear-gradient(top, #6d6d6d 0%,#1e1e1e 100%);
		background: -ms-linear-gradient(top, #6d6d6d 0%,#1e1e1e 100%);
		background: linear-gradient(to bottom, #6d6d6d 0%,#1e1e1e 100%);
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#6d6d6d', endColorstr='#1e1e1e',GradientType=0 );
	/*	-webkit-box-shadow: 0 2px 4px 0 #999;
		box-shadow: 0 2px 4px 0 #999; */
		-webkit-transition: all 1s ease;
		-moz-transition: all 1s ease;
		-ms-transition: all 1s ease;
		-o-transition: all 1s ease;
		transition: all 1s ease;
	}
	.buttonStyle:hover {
		background: #1e1e1e;
		color: #fff;
		background: -moz-linear-gradient(top, #1e1e1e 0%, #6d6d6d 100%, #6d6d6d 100%);
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#1e1e1e), color-stop(100%,#6d6d6d), color-stop(100%,#6d6d6d));
		background: -webkit-linear-gradient(top, #1e1e1e 0%,#6d6d6d 100%,#6d6d6d 100%);
		background: -o-linear-gradient(top, #1e1e1e 0%,#6d6d6d 100%,#6d6d6d 100%);
		background: -ms-linear-gradient(top, #1e1e1e 0%,#6d6d6d 100%,#6d6d6d 100%);
		background: linear-gradient(to bottom, #1e1e1e 0%,#6d6d6d 100%,#6d6d6d 100%);
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#1e1e1e', endColorstr='#6d6d6d',GradientType=0 );
	}
.returnToProfile {text-align: center; margin:3em;}
.returnToProfile a, .returnToProfile a:visited {color: #ddd;}
.returnToProfile a:hover {color: #fff;}
/*modal end*/
.new_box{
    padding: 0.4rem;
    height: 50px;
}
@media only screen and (max-width: 600px) {
  .logggin {
    display:none;
  }
}
.font-11{
    font-size:10px;
}
</style>
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>

<div class="container-fluid">
                    <!-- Page-Title -->
                    <div class="row">
                        <div class="col-sm-12">
              <?php $error_message = $this->session->userdata('error_message');
				if (isset($error_message)) {
			  ?>
					<div class="alert alert-danger">
						<?php echo $error_message ?>                    
					</div>
				<?php
					$this->session->unset_userdata('error_message');
				} ?>
				<?php 
    				$success_message = $this->session->userdata('success_message');
    				if (isset($success_message)) {
				?>
					<div class="alert alert-success">
						<?php echo $success_message ?>                    
					</div>
				<?php
					$this->session->unset_userdata('success_message');
				} ?>
                       <!--</div><!--end page-title-box-->
                        </div><!--end col-->
                    </div>
                <!-- end page title end breadcrumb -->
                <div class="row">
                    <div class="col-sm-12">
                    <h2 style="text-align:center;">Welcome To Dashboard!</h2>
                    </div> 
                </div>
                
                <div class="row">
                        <? if(!empty($role_permissions) && in_array(261,$role_permissions)) { ?>
                        <div class="col-lg-12">
                            <div class="card" style="background: #a1f39a;border: 1px solid #a1f39a;box-shadow: 0 10px 16px 0 #30635c, 0 6px 20px 0 rgb(255 255 255) !important;">
                                <div class="card-body">
                                    <h4 class="header-title mt-0 mb-3">All Plants</h4>
                                    <div class="table-responsive browser_users">
                                        <table class="table mb-0 tablex">
                                            <thead class="">
                                            	<tr>
                                            		<!--<th>#</th>-->
                                            		<th>Plant Name</th>
                                            		<th>Address</th>
                                            		<th>Status</th>
                                            		<th>Date</th>
                                            		<th>#</th>
                                            	</tr>
                                        	</thead>
                                        	<tbody>
                                            <?php 
                                                if($locations){
    											foreach($locations as $loca){
											?>
                                        		<tr>
                                        			<!--<td ><?//php echo $i;?></td>-->
                                        			<td><?= ucfirst($loca['fld_location']);?></td>
                                        			<td><?= ucfirst($loca['fld_address']);?></td>
                                        			<td>
                                        			    <?php if($loca['fld_status'] == 1){
            												echo 'Enable';
            											}elseif($loca['fld_status'] == 0){
            												echo 'Disable';
            											}else{
            												echo '';
            											} ?>
            										</td>
											        <td><?= date('d-M-Y',strtotime($loca['fld_created_date']));?></td>
                                        			<td ><a href="<?= base_url('Common/detail/'.$loca['fld_id'].'');?>"><i style="font-size:15px;cursor:pointer;" class="mdi mdi-eye-circle-outline" title="View"></i></a></td>
                                        		</tr>
                                        		<?php } }else{ ?>
                                        		<tr><td colspan="4" style="text-align:center;color:red;">Sorry No Record Found</td>
                                        		</tr>
                                        		<?php } ?>
                                        	</tbody>
                                        </table> <!--end table-->                                               
                                    </div><!--end /div-->
                                    <!--<div class="more" style="text-align:center;">-->
                                    <!--    <a href="<?//= base_url('Stocks/tableviewlpg');?>" class=""><u>View More</u></a>-->
                                    <!--</div>-->
                                </div><!--end card-body-->
                            </div><!--end card-->
                        </div><!--end col-->
                        <? } ?>
                        
                        <? if(!empty($role_permissions) && in_array(262,$role_permissions)) { ?>
                         <div class="col-lg-12">
                            <div class="card" style="background: #9e9e9e;border: 1px solid #9e9e9e;box-shadow: 0 10px 16px 0 #30635c, 0 6px 20px 0 rgb(255 255 255) !important;" >
                                <div class="card-body">
                                    <h4 class="header-title mt-0 mb-3" style="color: #ffffff;">Activity Logs</h4>
                                    <div class="table-responsive browser_users">
                                        <table class="table log">
                                            <thead>
                                                <tr>
        											<th>Date</th>
                                                    <th>Login</th>
                                                    <th>Action</th>
                                                    <th>IP</th>
                                                    <th>Address</th>
                                                    <th>Device</th>
                                                </tr>
                                            </thead>
                                            <tbody>
        										<?php if($activity_logs){
        											$i=1;
        											foreach($activity_logs as $logs){
        											    $user=$this->db->query("select * from tbl_users where fld_id='{$logs['fld_user_id']}'")->row_array();
        										?>
        											<tr>
        												<td><?= date('H:i',strtotime($logs['fld_added_date']));?></td>
        												<td><?= $user['fld_username'];?></td>
        												<td><?= $logs['fld_action'];?></td>
        												<td><?= $logs['fld_ip_address'];?></td>
        												<td style="font-size:9px !important;"><?= $logs['fld_address'];?></td>
        												<td style="font-size:9px !important;;"><?= $logs['fld_device'];?></td>
        											</tr>
        										<?php $i++;}}?>
                                            </tbody>
                                        </table> <!--end table-->                                               
                                    </div><!--end /div-->
                                     <div class="more" style="text-align:center;">
                                        <a href="<?= base_url('Settings/log_system');?>" class=""><u>View More</u></a>
                                    </div>
                                </div><!--end card-body-->
                            </div><!--end card-->
                        </div><!--end col-->
                        <? } ?>
                    </div>
</div>
<script>
    window.onload = function() {
        document.getElementById('button').onclick = function() {
        document.getElementById('modalOverlay').style.display = 'none'
        };
    };
</script>
                