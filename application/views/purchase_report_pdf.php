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
            ?>
            <td>
                <div class="detail text-left" >
                     <span style="font-weight:bold;font-size:10px;">&nbsp;Type:</span>&nbsp;<span class="" style="font-size:10px;">Purchase Report</span><br>
                     <span style="font-weight:bold;font-size:10px;">&nbsp;Showing Report As:</span>&nbsp;<span style="font-size:10px;"><?php echo str_replace('_', ' ', $_GET['filter']); ?>, <?php if($_GET['filter_type']==1){echo 'Detailed';}else{echo 'Summary';} ?> </span> <br>
                     <span style="font-weight:bold;font-size:10px;">&nbsp;From:</span>&nbsp;<span class="fromDate" style="font-size:10px;"><?php echo $_GET['from_date']; ?></span><br>
                     <span style="font-weight:bold;font-size:10px;">&nbsp;To:</span>&nbsp;<span class="toDate" style="font-size:10px;"><?php echo $_GET['to_date']; ?></span>
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
		<th>Bill ID</th>
		<th>Account</th>
		<th>Item</th>
		<th>Remarks</th>
		<th>Qty</th>
		<th>Weight</th>
		<th>Rate</th>
		<th>Amount(Pkr)</th>
	</tr>
	</thead>


<tbody class="purchaseRows" id="purchaseRows">
		 <?php if($purchase){
			 $i=1;
			 $b=1;
			 $amtqty=0;
			 $akgqty=0;
			 $total_all_amount=0;
			foreach($purchase as $purch){
			?>
		<tr class="search_filter">
			<td colspan="10" style="padding-left: 24%;"><?php echo $purch['filter_text'];?></td>

		</tr>
				<?php
				$mtqty=0;
				$kgqty=0;
				$total_amount=0;
				foreach($purch['detail'] as $purdet){
					$mtqty=$mtqty + $purdet['fld_quantity'];
					$total_amount=$total_amount + $purdet['fld_total_amount'];
					if($purdet['fld_product_id']==1){
				    	$kgqty=$kgqty + ($purdet['fld_quantity'] * 1000);
					}else{
					   //	$kgqty=$kgqty + ($purdet['fld_quantity']);
					   	$kgqty=0; 
					}
					if($filter_type == 1){
					    $subcat = '';
					    if($purdet['fld_subproduct_id'] != '0'){
					        $subcat = ' - '.$this->db->query("select * from tbl_subcategory where fld_subcid = '{$purdet['fld_subproduct_id']}'")->row()->fld_subcategory;
					    }
					?>
					<tr>
						<td ><?php echo $i;?></td>
						<td ><?php echo date('d-m-Y',strtotime($purdet['fld_purchase_date']));?></td>
						<td ><?php echo $purdet['fld_voucher_no'];?></td>
						<td ><?php echo $purdet['fld_supplier_name'];?></td>
						<td ><?php echo $purdet['fld_category'].$subcat;?></td>
						<td ><?php echo $purdet['fld_shipment'];?></td>
						<td ><?php echo $purdet['fld_quantity'];?></td>
						<?/*<td ><?php echo ((int)$purdet['fld_quantity'] > 0)?(int)$purdet['fld_quantity'] * 1000:0;?></td>*/?>
						<td ><?php if($purdet['fld_product_id']==1){ echo round($purdet['fld_quantity']*1000,2); }else{echo '-';}?></td>
						<td ><?php echo $purdet['fld_unit_price'];?></td>
						<td ><?php echo $purdet['fld_total_amount'];?></td>
					</tr>
					<?php $i++; }}?>
		
		<tr class="search_finalsum">
			<td colspan="7" style="text-align:right;font-weight:bold;">TOTAL</td>
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
			<td colspan="7" style="text-align:right;font-weight:bold;">NET TOTAL</td>
			<td ><?= number_format($amtqty,2);?></td>
			<td ><?= number_format($akgqty,2);?></td>
			<td><?= number_format($total_all_amount,2);?></td>
		</tr>
		<?php }else{?>
		<tr><td colspan="10" style="text-align:center;color:red;">Sorry No Record Found</td></tr>
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
