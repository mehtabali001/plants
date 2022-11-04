<style>
h3{
    text-align:center;
}
p{
    text-align:center;
}
.search_filter td {
    /*border: none !important;*/
    color: #000;
    font-weight: bold;
}
.search_finalsum td {
    /*border: none !important;*/
    /*background: rgb(245 222 179) !important;*/
    color: white;
    font-weight: bold;
}
.even{
    color:green;
}
.odd{
    color:red;
}
.search_finalsum td {
    color: black !important;
}
</style>

<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<h3>Income Report</h3>
<p><?=$start_date;?>&nbsp;&nbsp;&nbsp;<span>To</span>&nbsp;&nbsp;&nbsp;<?=$end_date;?></p>
<?php //if($navigation){ ?>
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right" style="margin-bottom: 15px;">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                    <? if(!empty($role_permissions) && in_array(228,$role_permissions)) { ?>
                    <a type="button" id="print_report" onclick="printPdfIncomeReport(1);" class="btn btn-outline-primary print_report" disabled><i class="fa fa-print" aria-hidden="true"></i>&nbsp;Print</a>
                    <? } ?>
                    <? if(!empty($role_permissions) && in_array(229,$role_permissions)) { ?>
                    <a type="button" id="pdf_purchase_report" class="btn btn-outline-primary pdf_purchase_report" onclick="printPdfIncomeReport(2);" disabled><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;PDF</a>
                    <? } ?>
                    <? if(!empty($role_permissions) && in_array(230,$role_permissions)) { ?>
                    <a type="button" id="incomereport_csv" class="btn btn-outline-primary pdf_purchase_report"  onclick="downloadcsv();" disabled><i class="fas fa-file-csv"></i>&nbsp;CSV</a>
                    <? } ?>
                </div>
			</div>
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<? //} ?>
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
