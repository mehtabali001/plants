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
            <td style="width:65%;text-align:left">
                <img class="company-logo" src="<?=base_url()?>/assets/uploads/logo/<?=$settings['system_logo'];?>" style="height:70px;float:left;">
            </td>
            <td>
                <div class="detail text-left" >
                    <span style="font-weight:bold;font-size:10px;">Type:</span>&nbsp;<span class="" style="font-size:10px;">Navigation Report</span><br>
                     <span style="font-weight:bold;font-size:10px;">Showing Report As:</span>&nbsp;<span style="font-size:10px;"> <?php echo str_replace('_', ' ', $_GET['filter']); ?>, <?php if($_GET['filter_type']==1){echo 'Detailed';}else{echo 'Summary';} ?> </span><br>
                     <span style="font-weight:bold;font-size:10px;">From:</span>&nbsp;<span class="fromDate" style="font-size:10px;"><?php echo $_GET['from_date']; ?></span><br>
                     <span style="font-weight:bold;font-size:10px;">To:</span>&nbsp;<span class="toDate" style="font-size:10px;"><?php echo $_GET['to_date']; ?></span><br>
                </div>
            </td>
        </tr>
    </tbody>
</table>

<hr style="width:100%;">
<table class="table " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
	<thead class="dthead">
    	<tr>
    		<th>Navigation Date</th>
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

<tbody class="purchaseRows" id="purchaseRows">
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
						<td ><?php echo number_format($navdet['fld_amount'],2);?></td>
						<td ><?php echo number_format($navdet['fld_freight_MT'],2);?></td>
						<td ><?php echo number_format($navdet['fld_freight_amount'],2);?></td>
						<td ><?php echo number_format($navdet['fld_total_amount'],2);?></td>
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
