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
    color: white;
    font-weight: bold;
}
.table td {
    vertical-align: middle;
    font-size: 10px !important;
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
.btn-group{
    margin-bottom: 14px;
    border-radius: 5px;
}
.btn-group a:hover{
    color:#FFF;
}
</style>
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>

<?php if($purchase){ ?>
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
				  <? if(!empty($role_permissions) && in_array(9,$role_permissions)) { ?>
                    <!--<button type="button" style="background-color: DodgerBlue;" id="print_report" class="btn print_report" name="" value="" disabled><i class="fa fa-print" aria-hidden="true"></i>&nbsp;Print Report F6</button>-->
                    <a type="button"  id="print_report" class="btn btn-outline-primary print_report" disabled><i class="fa fa-print" aria-hidden="true"></i>&nbsp;Print</a>
                    <? } ?>
                    <? if(!empty($role_permissions) && in_array(11,$role_permissions)) { ?>
                    <!--<button type="button" id="pdf_purchase_report" class="btn btn-gradient-pink pdf_purchase_report" name="" value="" disabled><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;PDF F7</button>-->
                     <a type="button"  id="pdf_purchase_report" class="btn btn-outline-primary pdf_purchase_report" disabled><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;PDF</a>
                    <? } ?>
                    <? if(!empty($role_permissions) && in_array(215,$role_permissions)) { ?>
                    <!--<button type="button" id="purchase_report_csv" class="btn btn-csv pdf_purchase_report" disabled onclick="downloadcsv();"  name="" value=""><i class="fas fa-file-csv"></i>&nbsp;CSV</button>-->
                    <a type="button" id="purchase_report_csv" class="btn btn-outline-primary pdf_purchase_report" disabled  onclick="downloadcsv();"><i class="fa fa-file-csv" aria-hidden="true"></i>&nbsp;CSV</a>
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
		<th style="width: 4%;">#</th>
		<th>Billing Date</th>
		<th>Bill ID</th>
		<th style="width: 13%;">Account</th>
		<th>Item</th>
		<th>Shipment</th>
		<th style="width: 6%;">Qty</th>
		<th style="width: 7%;">Weight</th>
		<th>Rate</th>
		<th>Amount(PKR)</th>
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
			<td colspan="10" style="text-align:center;"><?php echo $purch['filter_text'];?></td>
            <td style="display:none;"></td>
            <td style="display:none;"></td>
            <td style="display:none;"></td>
            <td style="display:none;"></td>
            <td style="display:none;"></td>
            <td style="display:none;"></td>
            <td style="display:none;"></td>
            <td style="display:none;"></td>
            <td style="display:none;"></td>
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
					   //$kgqty=$kgqty + ($purdet['fld_quantity']); 
					   $kgqty += 0; 
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
						<td ><?php if($purdet['fld_product_id']==1){ echo round($purdet['fld_quantity']*1000,2); }else{echo '-';}?></td>
						<td ><?php echo $purdet['fld_unit_price'];?></td>
						<td ><?php echo $purdet['fld_total_amount'];?></td>
					</tr>
					<?php $i++; }}?>
		
		<tr class="search_finalsum total">
			<td colspan="6" style="text-align:right;font-weight:bold;">TOTAL</td>
			<td ><?= number_format($mtqty,2);?></td>
			<td ><?= number_format($kgqty,2);?></td>
			<td></td>
			<td><?= number_format($total_amount,2);?></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
		</tr>
			<?php
		$b++;
			$total_all_amount += $total_amount;
			$akgqty += $kgqty;
		$amtqty += $mtqty;
		$counter = $i;
		} ?>
			</tbody>
	
		<!--<tfoot class="">-->
		<tr class="search_finalsum tablebottom">
			<td colspan="6" style="text-align:right;font-weight:bold;">NET TOTAL</td>
			<td ><?= number_format($amtqty,2);?></td>
			<td ><?= number_format($akgqty,2);?></td>
			<td></td>
			<td><?= number_format($total_all_amount,2);?></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
		</tr>
		<!--</tfoot>-->
		<?php }else{?>
		<tr><td colspan="10" style="text-align:center;color:red;">Sorry No Record Found</td>
		    <td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
		</tr>
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
            "infoCallback": function( settings, start, end, max, total, pre ) {
                var api = this.api();
                var pageInfo = api.page.info();
                return 'Page '+ (pageInfo.page+1) +' of ' + pageInfo.pages + ' of ' + <?= $counter - 1; ?> +' entries';
              },
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