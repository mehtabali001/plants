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
                                            <? $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row_array();?>
                                            <td style="width:60%;text-align:left">
                                                <img class="company-logo" src="<?=base_url()?>/assets/uploads/logo/<?=$settings['system_logo'];?>" style="height:70px;float:left;">
                                            </td>
                                            <td>
                                                <div class="detail text-left" >
                                                    <span style="font-weight:bold;">Type:</span>&nbsp;<span> Navigation Report </span><br>
                                                     <span style="font-weight:bold;">Showing Report As:</span>&nbsp;<span><?php echo str_replace('_', ' ', $_GET['filter']); ?>, <?php if($_GET['filter_type']==1){echo 'Detailed';}else{echo 'Summary';} ?> </span><br>
                                                     <span style="font-weight:bold;">From:</span>&nbsp;<span class="fromDate"><?=$_GET['from_date'];?></span><br>
                                                     <span style="font-weight:bold;">To:</span>&nbsp;<span class="toDate"><?=$_GET['to_date'];?></span></span>
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
									<thead class="htmlRows1">
    									<tr>
                                    		<th>Navigation Date</th>
                                    		<!--<th>Vr#</th>-->
                                    		<th>From</th>
                                    		<th>To</th>
                                    		<th>Item</th>
                                    		<th>Shipment</th>
                                    		<th>Weight(MT)</th>
                                    		<th>Rate<br>(PKR)</th>
                                    		<th>Amount<br>(PKR)</th>
                                    		<th>Freight<br>(MT)</th>
                                    		<th>Total Freight</th>
                                    		<th>Total <br>Amount<br>(PKR)</th>
                                    	</tr>
									</thead>
								
									<tbody id="htmlRows">
		 <?php if($navigation){
			 $i=1;
			 $b=1;
			 $amtqty=0;
			 $akgqty=0;
			 $total_all_amount = 0;
			foreach($navigation as $nav){
		 ?>
    		<tr class="search_filter">
    			<td colspan="11" style="padding-left: 24%;"><?php echo $nav['filter_text'];?></td>
    		</tr>
			<?php
				$mtqty=0;
				$kgqty=0;
				$total_amount=0;
				foreach($nav['detail'] as $navdet){
					$mtqty=$mtqty + $navdet['fld_qty'];
					$total_amount=$total_amount + $navdet['fld_total_amount'];
					$kgqty=$kgqty + ($navdet['fld_qty'] * 1000);
					if($filter_type == 1){
					    $loc_from = $this->db->query("select * from tbl_locations where fld_id = '{$navdet['fld_location_from']}'")->row()->fld_location;
					    $loc_to = $this->db->query("select * from tbl_locations where fld_id = '{$navdet['fld_location_to']}'")->row()->fld_location;
					    $subcat = '';
					    if($navdet['fld_subproduct_id'] != '0'){
					        $subcat = ' - '.$this->db->query("select * from tbl_subcategory where fld_subcid = '{$navdet['fld_subproduct_id']}'")->row()->fld_subcategory;
					    }
			?>
					<tr>
						<td ><?php echo date('d-m-Y',strtotime($navdet['fld_date']));?></td>
						<!--<td ><?php //echo $purdet['fld_voucher_no'];?></td>-->
						<td ><?php echo $loc_from;?></td>
						<td ><?php echo $loc_to;?></td>
						<td ><?php echo $navdet['fld_category'].$subcat;?></td>
						<td ><?php echo $navdet['fld_shipment_from'];?></td>
						<!--<td ><?php// echo $navdet['fld_shipment_to'];?></td>-->
						<!--<td ><?//php echo $navdet['fld_remarks'];?></td>-->
						<td ><?php echo $navdet['fld_qty'];?></td>
						<td ><?php echo $navdet['fld_rate'];?></td>
						<td ><?php echo $navdet['fld_amount'];?></td>
						<td ><?php echo $navdet['fld_freight_MT'];?></td>
						<td ><?php echo $navdet['fld_freight_amount'];?></td>
						<td ><?php echo $navdet['fld_total_amount'];?></td>
					</tr>
			<?php }}?>
		
    		<tr class="search_finalsum">
    			<td colspan="8" style="text-align:right;font-weight:bold;">TOTAL</td>
    			<td ><?= number_format($mtqty,2);?></td>
    			<td ><?= number_format($kgqty,2);?></td>
    			<td><?= number_format($total_amount,2);?></td>
    		</tr>
    		<?php
		$b++;
			$total_all_amount += $total_amount;
			$akgqty += $kgqty;
		$amtqty += $mtqty;
		} ?>
		<tr class="search_finalsum">
			<td colspan="8" style="text-align:right;font-weight:bold;">NET TOTAL</td>
			<td ><?= number_format($amtqty,2);?></td>
			<td ><?= number_format($akgqty,2);?></td>
			<td><?= number_format($total_all_amount,2);?></td>
		</tr>
		<?php }else{?>
    		<tr><td colspan="11" style="text-align:center;color:red;">Sorry No Record Found</td></tr>
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
		    <p style="position: sticky;font-style: italic; bottom: 0; color:#5d5d5d;"><span style="font-weight:bold;">Note:</span> This is auto generated report on <?= date('d - M - Y'); ?>, <?= date('h:i A'); ?> by <?= $this->session->userdata('user_name'); ?> account  and requires signature from the approval authority.</p>
		    </div>
	<script type="text/javascript" src="<?= base_url();?>/assets/theme_elements/js/jquery.min.js"></script>
	<script type="text/javascript">
		$(function(){

			var opener = window.opener;
			
			var fromDate = opener.$('#from_date').val();
			var toDate = opener.$('#to_date').val();			
			var etype = opener.$('.form-section').text();
			if (opener.$('#datatable3_tb').is(':visible')) {
				// var parentRows = opener.$(".purchaseRows tr");
				// var rowsHtml = '';

				// var parentRows1 = '';
				var parentRows1 = opener.$(".dthead tr").clone();
				$('.htmlRows1').append(parentRows1);
				// $(".htmlRows1").find('.printRemove').remove();
				
				// var netBalance = 0;
				 var parentCopy = opener.$('.purchaseRows tr').clone();
				 console.log(parentCopy);
				parentCopy.find('.printRemove').remove();
								

				$('#htmlRows').append(parentCopy);
				$("a").removeAttr("href");
				
		    }
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
			window.print();
			
		});
	</script>
	
</body>
</html>