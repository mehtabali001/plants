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
    border: 1px solid #eee !important;
    color: #000;
    /*font-weight: bold;*/
    padding: 7px;
}

</style>
<?php 
    $item = $this->db->query("SELECT * FROM tbl_category WHERE fld_id = '{$_GET['item_type']}'")->row_array();
    ?>
    <h2 style="float:left;margin-top: 6%;">Income statement.'<?=$item['fld_category']?>'</h2>
    <!--<img class="company-logo" src="https://erp.mktechsol.com//assets/custom_elements/images/logo.png" style="height:120px;float:right;">-->
    <? $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row_array();?>
                <img class="company-logo" src="<?=base_url()?>/assets/uploads/logo/<?=$settings['system_logo'];?>" style="height:120px;float:right;">
<hr style="width:100%;">
    <p style=" text-align: center;font-weight: bold;position: relative;"><?=$start_date?>&nbsp;&nbsp;&nbsp;<span>To</span>&nbsp;&nbsp;&nbsp;<?=$end_date?></p>
<table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
	


	<tbody class="ledgerRows" id="ledgerRows">
		    <tr class="search_filter">
		        <td style="width:30%;"></td>
    			<td style="">Particulars</td>
    			<td>PKR</td>
            </tr>
    		<tr class="search_filter">
    			<td colspan="2" style="">Revenue</td>
    			<td></td>
            </tr>
				
					<tr>
						<td></td>
						<td >Total Sale</td>
						<td ><?=number_format(($itemReport->amount), 2);?></td>
						
					</tr>
					<tr>
						<td></td>
						<td >Other Income</td>
						<td >0</td>
						
					</tr>
					<tr>
						<td></td>
						<td >Sale Discount</td>
						<td ><?=number_format($itemReport->discount,2);?></td>
						
					</tr>
					<tr>
						<td></td>
						<td style="font-weight:bold">Net Sale</td>
						<td ><?=number_format(($itemReport->amount-$itemReport->discount), 2);?></td>
						
					</tr>
					<tr>
						<td></td>
						<td style="font-weight:bold">Cost of Good Sold</td>
						<td ><?=number_format($itemReport->cgs,2);?></td>
						
					</tr>
					<tr>
						<td></td>
						<td style="font-weight:bold;color:#1dcfd9;">Gross Profit/Loss</td>
						<td > <? $revenue = ($itemReport->amount-$itemReport->discount)-$itemReport->cgs;
						echo number_format($revenue ,2);
						?></td>
						
					</tr>
					
		
		<tr class="search_finalsum">
			<td colspan="2" style="font-weight:bold;">Net Income</td>
			<td ><?=number_format(($revenue),2);?></td>
		</tr>
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
									<th style="color:black;background-color : white !important;border-top: 1px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;width:33%;">Prepared By</th>
									<th style="    background-color : white !important;    border-top: 1px solid white;width:33%;"></th>
									<th style="color:black;background-color: white !important;border-top: 1px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;width:33%;">Received By</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
				<div class="bel" style="position:absolute;bottom:2px;"><p style="font-style: italic;"><span style="font-weight:bold;font-style: italic;">Note:</span> This is auto generated report and requires signature from the approval authority.</p></div>
<script>
    	window.print();
</script>
