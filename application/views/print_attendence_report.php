<!DOCTYPE html>
<html>
<head>
	<title>Daybook Report </title>

	

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
@media print {
    /*th {  padding: 5px; color:#000; font-weight:bold;}*/
.detail span{
    text-align:left;
}
.desc{
    font-size:10px;
    font-weight:100;
}
/*.bel{*/
/*position:static;*/
/*bottom: 0;*/
/*font-size:12px;*/
/*padding-top:5px;*/
/*}*/
/*.bel p{*/
/*    font-style: italic;position:flex;display: block;bottom:0;font-size:10px;*/
/*}*/
}
@media print { 
body {
  position: relative;
  }
.bel p{ {
  
  }
}
</style>
</head>
<body>
	<div class="container-fluid" style="margin-top:10px;">
							      
                                  <table class="table table-borderless" style="width:100%;">
                                    <tbody>
                                        <tr>
                                            <td style="width:70%;text-align:left">
                                                <? $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row_array();?>
                                                <img class="company-logo" src="<?=base_url()?>/assets/uploads/logo/<?=$settings['system_logo'];?>" style="height:70px;float:left;">
                                            </td>
                                            <td>
                                                <div class="detail text-left" >
                                                     <span style="font-weight:bold;font-size:10px;">&nbsp;Showing Report As:</span>&nbsp;<span style="font-size:10px;"><?php echo str_replace('_', ' ', $_GET['filter']); ?> </span><br>
                                                     <span style="font-weight:bold;font-size:10px;">&nbsp;From:</span>&nbsp;<span class="fromDate" style="font-size:10px;"><?=$_GET['from_date'];?></span><br>
                                                     <span style="font-weight:bold;font-size:10px;">&nbsp;To:</span>&nbsp;<span class="toDate" style="font-size:10px;"><?=$_GET['to_date'];?></span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

<hr style="width:100%;">
								<!--<h3 class="text-center shadowhead txtbold"></h3>
								<h3 class="text-center AccName txtbold">.</h3>
								<p class="text-center"><span class="from"><strong>From:-</strong><span class="fromDate">[0000/00/00]</span></span> To <span class="to"><strong>To:-</strong><span class="toDate">[0000/00/00]</span></span></p>-->
								<table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;margin-top: 5%;">
									<thead class="dthead">
	<tr>
		 <th>Date</th>
        <th>Name</th>
		<th>Plant</th>
        <th>Designation</th>
		<th>In Time</th>
		<th>Out Time</th>
		<th>Status</th>
	</tr>
	</thead>


	<tbody class="purchaseRows" id="purchaseRows">
		 <?php if($attendence){
			 $i=1;
			 $b=1;
			foreach($attendence as $purch){
			?>
		<tr class="search_filter">
			<td colspan="7" style="padding-left: 24%;"><?php echo $purch['filter_text'];?></td>

		</tr>
				<?php
				foreach($purch['detail'] as $purdet){
					$designation =	$this->Common_model->select_single_field('designation_name','tbl_designation',array('id'=>$purdet['designation']));
					$plant       =	$this->Common_model->select_single_field('fld_location','tbl_locations',array('fld_id'=>$purdet['plants']));
					$name        =	$this->Common_model->select_single_field('full_name','tbl_employees',array('id'=>$purdet['user_id']));
					
					if($purdet['attendance_status'] == 'Present'){
					    $color = "color:green";
					}elseif($purdet['attendance_status'] == 'Absent'){
					    $color = "color:red";
					}elseif($purdet['attendance_status'] == 'Sick Leave'){
					    $color = "color:#506ee4";
					}elseif($purdet['attendance_status'] == 'Short Leave'){
					    $color = "color:#506ee4";
					}
					
					?>
					<tr>
						<td ><?php echo date('d-m-Y',strtotime($purdet['attendance_date']));?></td>
						<td><?=$name;?></td>
						<td><?=$plant;?></td>
                        <td><?=$designation;?></td>
                        <td data-name="check_in" class="check_in" data-type="text" data-pk="<?=$purdet['attendance_id'];?>"> 
						  <?=$purdet['check_in'];?>
						</td>
							<td data-name="check_out" class="check_out" data-type="text" data-pk="<?=$purdet['attendance_id'];?>">
							  <?=$purdet['check_out'];?>
							</td>
                            <td data-name="attendance_status" class="attendance_status" data-type="select" data-pk="<?=$purdet['attendance_id'];?>" style="<?=$color?>">
							  <?=$purdet['attendance_status'];?>
							</td>
						
					</tr>
					<?php $i++; }?>
		
	
		<?php
		$b++;
		}}else{?>
		<tr><td colspan="7" style="text-align:center;color:red;">Sorry No Record Found</td></tr>
		<?php } ?>
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
				<br>
			<div class="row-fluid">
					<div class="span12">
						<table class="signature-fields" style="width:100%;">
							<thead>
								<tr>
									<th style="color:black;background-color : white !important;border-top: 1px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;width:33%;">Prepared By</th>
									<th style="    background-color : white !important;    border-top: 1px solid white;width:33%;"></th>
									<th style="color:black;background-color: white !important;border-top: 1px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;width:33%;">Received By</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		<div class="bel">
		    <p style="position: sticky; bottom: 0;"><span style="font-weight:bold;">Note:</span> This is auto generated report on <?= date('d - M - Y'); ?>, <?= date('h:i A'); ?> by <?= $this->session->userdata('user_name'); ?> account  and requires signature from the approval authority.</p>
		    </div>
	<script type="text/javascript" src="<?= base_url();?>/assets/theme_elements/js/jquery.min.js"></script>

	<script type="text/javascript">
		$(function(){
		   
			window.print();
			
		});
	</script>
</body>
</html>