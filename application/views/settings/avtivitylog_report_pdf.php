<style>
h3{
    text-align:center;
}
/*p{*/
/*    text-align:center;*/
/*}*/
.search_filter td {
    /*border: none !important;*/
    color: #000;
    font-weight: bold;
}
td {
    border: 1px solid #aba9a9fa !important;
    color: #000;
    /*font-weight: bold;*/
    padding: 7px;
}

.table thead th{
    border:1px solid #aba9a9fa;
}
.table-borderless td{
    border:0px !important;
}
.text-center{
    text-align:center;
}
.text-right{
    text-align:right;
}
.detail span{
    text-align:left;
}
.text-left{
    text-align:left;
}
.detail span{
    font-size:12px;
}
@media print {
    /*th {  padding: 5px; color:#000; font-weight:bold;}*/
.detail span{
    text-align:left;
    font-size:10px !important;
}
.desc{
    font-size:10px;
    font-weight:100;
}
}
</style>
<table class="table table-borderless">
    <tbody>
        <tr>
            <? $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row_array();?>
            <td style="width:66%;text-align:left">
                <img class="company-logo" src="<?=base_url()?>/assets/uploads/logo/<?=$settings['system_logo'];?>" style="height:70px;float:left;">
            </td>
            
            <td>
                <div class="detail text-left" >
                     <span style="font-weight:bold;font-size:10px;">&nbsp;Type:</span>&nbsp;<span class="" style="font-size:10px;">Logs Report</span><br>
                    
                     <span style="font-weight:bold;font-size:10px;">&nbsp;From:</span>&nbsp;<span class="fromDate" style="font-size:10px;"><?php echo $_GET['from_date']; ?></span><br>
                     <span style="font-weight:bold;font-size:10px;">&nbsp;To:</span>&nbsp;<span class="toDate" style="font-size:10px;"><?php echo $_GET['to_date']; ?></span>
                </div>
            </td>
        </tr>
    </tbody>
</table>

<hr style="width:100%;">
<table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="tabletop">
    <tr>
        <th>#</th>
		<th>Date</th>
        <th>User ID</th>
        <th>Role</th>
        <th>Action</th>
        <th>Details</th>
        <th>IP</th>
        <th>Address</th>
        <th>Device</th>
    </tr>
    </thead>
    <tbody id="customerRows" class="customerRows">
	<?php if($activity_logs){
											$i=1;
											foreach($activity_logs as $act_logs){
										?>
										<tr class="search_filter">
											<td colspan="9" style="text-align:center;"><?php if($_GET['filter'] == "Date_Wise"){ echo date('d-m-Y',strtotime($act_logs['filter_text']));}else{echo $act_logs['filter_text'];}?></td>
										
											
									   </tr>
									   <?php if(!empty($act_logs['detail'])){ foreach(@$act_logs['detail'] as $logs){?>
											<tr>
												<td><?= $i;?></td>
												<td><?= date('d-m-Y H:i',strtotime($logs['fld_added_date']));?></td>
												<td><?= $logs['fld_username'];?></td>
												<td><?= $logs['fld_role_name'];?></td>
												<td><?= $logs['fld_action'];?></td>
												<td><?= $logs['fld_detail'];?></td>
												<td><?= $logs['fld_ip_address'];?></td>
												<td><?= $logs['fld_address'];?></td>
												<td><?= $logs['fld_device'];?></td>
												
											</tr>
										<?php $i++;}}}}else{?>
										<tr>
										    <td colspan="9" style="text-align:center;color:red;">Sorry No Record Found</td>
										    <td style="display:none;"></td>
											<td style="display:none;"></td>
											<td style="display:none;"></td>
											<td style="display:none;"></td>
											<td style="display:none;"></td>
											<td style="display:none;"></td>
											<td style="display:none;"></td>
											<td style="display:none;"></td>
										</tr>
										<?}?>
    </tbody>
</table>
<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<div class="row-fluid">
					<div class="span12">
						<table class="signature-fields" style="width:100%;">
							<thead>
								<tr>
									<th style="color:black;background-color: white !important;border-top: 1px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;width:33%;">Prepared By</th>
									<th style="background-color : white !important;    border-top: 1px solid white;width:33%;"></th>
									<th style="color:black;background-color: white !important;border-top: 1px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;width:33%;">Received By</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
				<div class="bel" style="position:absolute;bottom:2px;font-size:10px;"><p style="position:absolute;bottom:2px;font-style: italic;color:#5d5d5d;"><span style="font-weight:bold;font-style: italic;">Note:</span> This is auto generated report , on <?= date('d - M - Y'); ?> <?= date('h:i A'); ?> by <?= $this->session->userdata('user_name'); ?> login and requires signature from the approval authority.</p></div>
<script>
    	window.print();
</script>
