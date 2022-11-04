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
            <td style="width:65%;text-align:left">
                <? $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row_array();?>
                <img class="company-logo" src="<?=base_url()?>/assets/uploads/logo/<?=$settings['system_logo'];?>" style="height:70px;float:left;">
            </td>
            <td>
                <div class="detail text-left" >
                     <span style="font-weight:bold;font-size:10px;">&nbsp;Report Type:&nbsp;</span><span style="font-size:10px;"> Employee Report </span><br>
                     <span style="font-weight:bold;font-size:10px;">&nbsp;Showing Report As:</span>&nbsp;<span style="font-size:10px;"> <?php echo str_replace('_', ' ', $_GET['filter']); ?> <br>
                </div>
            </td>
        </tr>
    </tbody>
</table>

<hr style="width:100%;">
<table class="table " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
	<thead class="dthead">
	    <tr>
            <th>Employee Code</th>
            <th>Name</th>
            <th>Role</th>
            <th>Cnic No.</th>
            <th>Contact No.</th>
            <th>Joining Date</th>
        </tr>
	</thead>
	<tbody id="employee_data" class="employee_data">
                        <?php 
                            if($employees){
                            foreach($employees as $emp){ 
                            
                        ?>
                        <tr class="search_filter">
                			<td colspan="6" style="padding-left: 24%; font-weight:bold;color:black;"><?php echo $emp['filter_text'];?></td>
                		</tr>
                		<?php 
                		foreach($emp['detail'] as $empdet){ ?>
                        <tr>
                            <td><?= $empdet['employee_code'];?></td>
                            <td><?= $empdet['full_name'];?></td>
                            <td><?= $empdet['designation_name'];?> at <?= $empdet['fld_location'];?> in <?= $empdet['department_name'];?></td>
                            <td><?= $empdet['cnic'];?></td>
                            <td><?= $empdet['mobile_no'];?></td>
                            <td><?= $empdet['joining_date'];?></td>
                        </tr>
                        
                        <?php }}} else{?>
		<tr><td colspan="6" style="text-align:center;color:red;">Sorry No Record Found</td></tr>
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
