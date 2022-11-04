<style>
th {
  position: sticky !important;
  border: 1px solid #f1f5fa;
  /*top: 50px;*/
  /*background: white;*/
}
.search_filter td {
    /*border: none !important;*/
    background: #f1f5fa !important;
    color: #000;
    font-weight: bold;
}
.search_finalsum td {
    /*border: none !important;*/
    /*background: rgb(245 222 179) !important;*/
    color: #000;
    font-weight: bold;
    text-align:center;
}
.tablebottom td {
    /*border: none !important;*/
    /*background: rgb(245 222 179) !important;*/
    color: #fff;
    font-weight: bold;
    text-align:center;
}
.table td {
    vertical-align: middle;
    font-size: 10px !important;
}
.table th, .table td {
    padding: 0.5rem !important;
}
.dataTables_filter{
    float:right;
}
@media only screen and (max-width: 600px) {
.page-title-box{
    display:none;
}
.dataTables_length label{
    width:100%;
}
.dataTables_filter{
   width:100%; 
}
.dataTables_filter label{
   width:100%; 
}
.pagination{
    width: 100%;
}
}
.table {
    margin-bottom: 0;
}
.table-bordered {
    border: 0;
}
</style>
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<?php if($navigation){ ?>
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right" style="margin-bottom: 15px;">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
				  <? if(!empty($role_permissions) && in_array(19,$role_permissions)) { ?>
                    <!--<button type="button" style="background-color: DodgerBlue;" id="print_report" class="btn print_report" name="" value="" disabled><i class="fa fa-print" aria-hidden="true"></i>&nbsp;Print Report F6</button>-->
                    <a type="button" id="print_report" class="btn btn-outline-primary print_report" disabled><i class="fa fa-print" aria-hidden="true"></i>&nbsp;Print</a>
                    <? } ?>
                    <? if(!empty($role_permissions) && in_array(20,$role_permissions)) { ?>
                    <!--<button type="button" id="pdf_purchase_report" class="btn btn-gradient-pink pdf_purchase_report" name="" value="" disabled><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;PDF F7</button>-->
                     <a type="button"  id="pdf_purchase_report" class="btn btn-outline-primary pdf_purchase_report" disabled><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;PDF</a>
                    <? } ?>
                    <? if(!empty($role_permissions) && in_array(216,$role_permissions)) { ?>
                    <!--<button type="button" id="purchase_report_csv" class="btn btn-csv pdf_purchase_report" disabled onclick="downloadcsv();"  name="" value=""><i class="fas fa-file-csv"></i>&nbsp;CSV</button>-->
                    <a type="button" id="navigation_report_csv" class="btn btn-outline-primary pdf_purchase_report" disabled  onclick="downloadcsv();"><i class="fa fa-file-csv" aria-hidden="true"></i>&nbsp;CSV</a>
                    <? } ?>
                </div>
			</div>
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<? } ?>
<?php //if($filter_type == 1){?>
<table id="datatable3_tb" class="table table_report table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
	<thead class="dthead tabletop">
	<tr>
		<th>Navigation Date</th>
		<!--<th>Vr#</th>-->
		<th>From</th>
		<th>To</th>
		<th>Item</th>
		<th>Shipment</th>
		<!--<th>Shipment To</th>-->
		<!--<th>Remarks</th>-->
		<th>Weight<br>(MT)</th>
		<th>Rate <br>(PKR)</th>
		<th>Amount<br>(PKR)</th>
		<th>Freight<br>(MT)</th>
		<th>Total Freight</th>
		<th>Total <br>Amount<br>(PKR)</th>
	</tr>
	</thead>
	<?php if($navigation){
			 $i=1;
			 $b=1;
			 $amtqty=0;
			 $akgqty=0;
			 $total_all_amount = 0;
			 $total_allf_amount = 0;
			 $total_allt_amount = 0;
			foreach($navigation as $nav){
		 ?>
	<tbody class="purchaseRows" id="purchaseRows">
		 
    		<tr class="search_filter">
    			<td colspan="11" style="text-align:center;"><?php echo $nav['filter_text'];?></td>
    			<td style="display:none"></td>
    			<td style="display:none"></td>
    			<td style="display:none"></td>
    			<td style="display:none"></td>
    			<td style="display:none"></td>
    			<td style="display:none"></td>
    			<td style="display:none"></td>
    			<td style="display:none"></td>
    			<td style="display:none"></td>
    			<td style="display:none"></td>
    		</tr>
			<?php
				$mtqty=0;
				$kgqty=0;
				$total_amount=0;
				$total_amount_fright = 0;
				$total_amount_total=0;
				foreach($nav['detail'] as $navdet){
					$mtqty=$mtqty + $navdet['fld_qty'];
					$total_amount=$total_amount + $navdet['fld_amount'];
					$total_amount_fright += $navdet['fld_freight_amount'];
					$total_amount_total += $navdet['fld_total_amount'];
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
		
    		<tr class="search_finalsum" style="color:#000 !important;">
    			<td colspan="5" style="">TOTAL</td>
    			<td ><?= number_format($mtqty,2);?></td>
    			<td></td>
    			<td><?= number_format($total_amount,2);?></td>
    			<td></td>
    			<td><?= number_format($total_amount_fright,2);?></td>
    			<td><?= number_format($total_amount_total,2);?></td>
    			<td style="display:none"></td>
    			<td style="display:none"></td>
    			<td style="display:none"></td>
    			<td style="display:none"></td>
    		</tr>
	</tbody>
	<?php
		$b++;
			$total_all_amount += $total_amount;
			$total_allf_amount += $total_amount_fright;
			$total_allt_amount += $total_amount_total;
			$akgqty += $kgqty;
		$amtqty += $mtqty;
		} ?>
		<tr class="search_finalsum tablebottom">
			<td colspan="5" style="text-align:right;font-weight:bold;">NET TOTAL</td>
			<td ><?= number_format($amtqty,2);?></td>
			<td></td>
			<td><?= number_format($total_all_amount,2);?></td>
			<td></td>
			<td><?= number_format($total_allf_amount,2);?></td>
			<td><?= number_format($total_allt_amount,2);?></td>
			<td style="display:none"></td>
			<td style="display:none"></td>
			<td style="display:none"></td>
			<td style="display:none"></td>
		</tr>
		<?php }else{?>
    		<tr>
    		    <td colspan="11" style="text-align:center;color:red;">Sorry No Record Found</td>
    		    <td style="display:none"></td>
    			<td style="display:none"></td>
    			<td style="display:none"></td>
    			<td style="display:none"></td>
    			<td style="display:none"></td>
    			<td style="display:none"></td>
    			<td style="display:none"></td>
    			<td style="display:none"></td>
    			<td style="display:none"></td>
    			<td style="display:none"></td></tr>
    		<?php } ?>
</table>
<script>
// 	$('#datatable_tb').DataTable().clear().destroy();
    var table = $('#datatable3_tb').DataTable({
            "ordering": false,
            "pageLength": 100,
            "scrollX": true,
            //"dom": 'lpftrip',
            //"sDom": '<"top"flpi>rt</div><"bottom"><"clear">',
            //"sDom": '<"top"flp>rt<"bottom"i><"clear">',
            dom: "<'row'<'col-sm-12'p><'col-sm-6'l><'col-sm-6'f>>" +
"<'row'<'col-sm-12'tr>>" +
"<'row'<'col-sm-5'i><'col-sm-7'p>>",
language: {
    'paginate': {
      'previous': '<span class="previouspage"><</span>',
      'next': '<span class="nextpage">></span>'
    }
  }
});
</script>