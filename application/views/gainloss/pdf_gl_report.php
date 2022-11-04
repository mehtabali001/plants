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
            <? $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row_array();?>
            <td style="width:63%;text-align:left">
                <img class="company-logo" src="<?=base_url()?>/assets/uploads/logo/<?=$settings['system_logo'];?>" style="height:70px;float:left;">
            </td>
            ?>
            <td>
                <div class="detail text-left" >
                     <span style="font-weight:bold;font-size:10px;">&nbsp;Type:</span>&nbsp;<span class="" style="font-size:10px;">Gain/Loss Report</span><br>
                     <span style="font-weight:bold;font-size:10px;">&nbsp;Showing Report As:</span>&nbsp;<span style="font-size:10px;"> <?php echo str_replace('_', ' ', $_GET['filter']); ?>, <?php if($_GET['filter_type']==1){echo 'Detailed';}else{echo 'Summary';} ?> </span> <br>
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
    		<th>Sr#</th>
    		<th>Date</th>
    		<th>Vr#</th>
    		<th>Item</th>
    		<th>Plant</th>
    		<th>Type</th>
    		<th>Shipment</th>
    		<th>Qty(KG)</th>
    		<th>Rate/KG</th>
    		<th>Amount(Pkr)</th>
    	</tr>
	</thead>


	<tbody class="purchaseRows" id="purchaseRows">
		 <?php if($gain_loss){
			 $i=1;
			 $b=1;
			foreach($gain_loss as $gainloss){
			?>
		<tr class="search_filter">
			<td colspan="10" style="padding-left: 24%;"><?php echo $gainloss['filter_text'];?></td>

		</tr>
				<?php
				$mtqty=0;
				$kgqty=0;
				$total_amount=0;
				foreach($gainloss['detail'] as $gainlossdet){
					$mtqty=$mtqty + $gainlossdet['fld_quantity'];
					$total_amount=$total_amount + $gainlossdet['fld_total_amount'];
					$kgqty=$kgqty + ($gainlossdet['fld_quantity'] * 1000);
					if($filter_type == 1){
					   
					    
					?>
					<tr>
						<td ><?php echo $i;?></td>
						<td ><?php echo date('d-m-Y',strtotime($gainlossdet['fld_date']));?></td>
						<td ><?php echo $gainlossdet['fld_voucher_no'];?></td>
						<td ><?php echo $gainlossdet['fld_category'];?></td>
						<td ><?php echo $gainlossdet['fld_location'];?></td>
						<td ><?php if($gainlossdet['fld_type']==1){echo'Gain';}elseif($gainlossdet['fld_type']==2){echo'Loss';}elseif($gainlossdet['fld_type']==3){echo'Difference';}?></td>
						<td ><?php echo $gainlossdet['fld_shipment'];?></td>
						<td ><?php echo $gainlossdet['fld_quantity'];?></td>
						<td ><?php echo $gainlossdet['fld_unit_price'];?></td>
						<td ><?php echo $gainlossdet['fld_total_amount'];?></td>
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
		}}else{?>
		<tr><td colspan="10" style="text-align:center;">No Record Found</td></tr>
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
