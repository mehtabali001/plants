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
    /*font-size:10px !important;*/
}
.desc{
    /*font-size:10px;*/
    font-weight:100;
}
}
</style>
<table class="table table-borderless">
    <tbody>
        <tr>
            <td style="width:75%;text-align:left">
                <? $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row_array();?>
                <img class="company-logo" src="<?=base_url()?>/assets/uploads/logo/<?=$settings['system_logo'];?>" style="height:70px;float:left;">
            </td>
            <td>
                <div class="detail " style="float:right;margin-top: 4%;" >
                    <span style="font-weight:bold;">&nbsp;Type:</span>&nbsp;<span>Income Report</span><br>
                     <span style="font-weight:bold;">&nbsp;From:</span>&nbsp;<span class="" style=""><?=$start_date?></span><br>
                     <span style="font-weight:bold;">&nbsp;To:</span>&nbsp;<span class="" style=""><?=$end_date?></span>
                </div>
            </td>
        </tr>
    </tbody>
</table>
<hr style="width:100%;">
    <!--<p style=" text-align: center;font-weight: bold;position: relative;"><?//=$start_date?>&nbsp;&nbsp;&nbsp;<span>To</span>&nbsp;&nbsp;&nbsp;<?//=$end_date?></p>-->
<table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
	


	<tbody class="ledgerRows" id="ledgerRows">
		    <tr class="search_filter">
		        <td></td>
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
						<td ><?=number_format(($saleofproducts->amount+$saleofproducts->discount), 2);?></td>
						
					</tr>
					<tr>
						<td></td>
						<td >Other Income</td>
						<td ><?=number_format($OtherIncome, 2);?></td>
						
					</tr>
					<tr>
						<td></td>
						<td >Sale Discount</td>
						<td ><?=number_format($saleofproducts->discount, 2);?></td>
						
					</tr>
					<tr>
						<td></td>
						<td style="font-weight:bold">Net Sale</td>
						<td ><?=number_format($saleofproducts->amount, 2);?></td>
						
					</tr>
					<tr>
						<td></td>
						<td style="font-weight:bold">Cost of Good Sold</td>
						<td ><?=number_format($costOfGoodsSold,2);?></td>
						
					</tr>
					<tr>
						<td></td>
						<td style="font-weight:bold;color:#1dcfd9;">Gross Profit/Loss</td>
						<td > <?  $revenue = $saleofproducts->amount+$OtherIncome-$costOfGoodsSold;
						echo number_format($revenue, 2);
						?></td>
						
					</tr>
					
		
		
		
		<tr class="search_filter">
    			<td colspan="2">Expenses</td>
    			<td></td>
            </tr>
				
					<tr>
						<td></td>
						<td >Office Expenses</td>
						<td ><?=number_format($OfficeExpenses, 2);?></td>
						
					</tr>
					<tr>
						<td></td>
						<td >Mess Expenses</td>
						<td ><?=number_format($MessExpenses, 2);?></td>
						
					</tr>
					<tr>
						<td></td>
						<td >Staff Salaries</td>
						<td ><?=number_format($StaffSalaries, 2);?></td>
						
					</tr>
					
		
		<tr>
		    <td></td>
			<td style="font-weight:bold;color:#1dcfd9;">Total Expenses</td>
			<td ><?  $totalExpenses = $OfficeExpenses+$MessExpenses+$StaffSalaries;
			echo number_format($totalExpenses ,2);
			?></td>
		</tr>
		<tr class="search_finalsum">
			<td colspan="2" style="font-weight:bold;">Net Income</td>
			<td ><?=number_format(($revenue-$totalExpenses), 2);?></td>
		</tr>
		<tr>
			<td></td>
			<td >Dividend</td>
			<td ><?=number_format($Dividend, 2);?></td>
			
		</tr>
		
		<tr class="search_finalsum">
			<td colspan="2" style="font-weight:bold;">Dividend (Profit & Loss) A/C</td>
			<td ><?=number_format(abs(($revenue-$totalExpenses)-$Dividend), 2);?></td>
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
									<th style="color:black;background-color: white !important;border-top: 1px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;width:33%;">Prepared By</th>
									<th style="    background-color : white !important;    border-top: 1px solid white;width:33%;"></th>
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
