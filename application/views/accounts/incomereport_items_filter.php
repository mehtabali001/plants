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
</style>
<h3>Income Report</h3>
<p><?=$start_date?>&nbsp;&nbsp;&nbsp;<span>To</span>&nbsp;&nbsp;&nbsp;<?=$end_date?></p>
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
