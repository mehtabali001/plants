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
<table class="table table-borderless" style="width:100%;">
    <tbody>
        <tr>
            <td style="width:61%;text-align:left">
                <? $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row_array();?>
                <img class="company-logo" src="<?=base_url()?>/assets/uploads/logo/<?=$settings['system_logo'];?>" style="height:70px;float:left;">
            </td>
            <td>
                <div class="detail text-left" >
                     <? $plant_name =	$this->Common_model->select_single_field('fld_location','tbl_locations',array('fld_id'=>$_GET['plant_for']));?>
                     <span style="font-weight:bold;">Type:</span>&nbsp;<span class="" style="font-size:10px;">Stock's Report</span><br>
                     <span style="font-weight:bold;">Showing Report As:</span>&nbsp;<span  style="font-size:10px;"> <?php if(empty($plant_name)){echo "All Plants";}else{ echo $plant_name;} ?> </span><br>
                     <span style="font-weight:bold;">From:</span>&nbsp;<span class="fromDate" style="font-size:10px;"><?php echo $_GET['frmdate']; ?></span><br>
                     <span style="font-weight:bold;">To:</span>&nbsp;<span class="toDate" style="font-size:10px;"><?php echo $_GET['todate']; ?></span><br>
                </div>
            </td>
        </tr>
    </tbody>
</table>

<hr style="width:100%;">
<table class="table " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
<thead class="dthead">
	<tr>
		<th>#</th>
		<th>Date</th>
		<th>Plant Name</th>
		<th>Opening Stocks</th>
		<th>Purchase</th>
		<th>Sale</th>
		<th>Closing Stock</th>
	</tr>
	</thead>

	<tbody id="stock_data">
		<?php echo $datatr; ?>
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
<script type="text/javascript">
		$(function(){

			var opener = window.opener;
			
			var fromDate = opener.$('#from_date').val();
			var toDate = opener.$('#to_date').val();			
			var etype = opener.$('.form-section').text();
		
		   // var what =opener.$('#filter').val().toLowerCase();
		    var what =opener.$("#filter option:selected").text().toLowerCase();

			// Charts 
			
			// End Charts
			$('.fromDate').html(fromDate);
			$('.toDate').html(toDate);
			$('.reporttype').html(what);
			
			// alert(parentCopy);
			$('.shadowhead').html(etype);
			// $('.netBalance').html(netBal);
			//window.print();
			
		});
	</script>
<script>
    	window.print();
</script>
