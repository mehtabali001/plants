<style>
.search_filter td {
    border: none !important;
     background: #f1f5fa !important;
     text-align:center;
    color: #000;
    font-weight: bold;
}
.search_finalsum td {
     background: #fff !important;
    color: #000;
    font-weight: bold;
}
.table{
    font-size:12px !important;
}
/*.table th, .table td {*/
/*    padding-top:.75rem;*/
    /*padding: .25rem !important;*/
/*    padding-bottom:.75rem;*/
/*}*/
.tablebottom td {
    border: 1px;
    padding-top: 10px;
    padding-bottom: 10px;
}
.tabletop th{
    border: 1px;
    padding-top: 10px;
    padding-bottom: 10px;
}
.dataTables_filter{
    float:right;
}
.table th, .table td {
    padding: .65rem !important;
}
</style>
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<?php if($sales){ ?>
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right" style="margin-bottom: 15px;">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                <? if(!empty($role_permissions) && in_array(120,$role_permissions)) { ?>
                <a type="button" id="print_report" class="btn btn-outline-primary print_report" disabled><i class="fa fa-print" aria-hidden="true"></i>&nbsp;Print</a>
                <? } ?>
                <? if(!empty($role_permissions) && in_array(121,$role_permissions)) { ?>
                <a type="button" id="pdf_purchase_report" class="btn btn-outline-primary pdf_purchase_report" name="" value="" disabled><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;PDF</a>
                <? } ?>
                <? if(!empty($role_permissions) && in_array(220,$role_permissions)) { ?>
                <a type="button" id="sale_report_csv" class="btn btn-outline-primary pdf_purchase_report" onclick="downloadcsv();" disabled name="" value=""><i class="fas fa-file-csv"></i>&nbsp;CSV</a>
                <? } ?>
                </div>
			</div>
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<? } ?>

<?php //if($filter_type == 1){?>
<table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
	<thead class="dthead tabletop">
	<!--<tr>-->
		<!--<th>#</th>-->
		<th>Invoice Date</th>
		<th>Invoice ID</th>
		<th>Account</th>
		<th>Item</th>
		<th>Shipment</th>
		<th>Qty<br></th>
		<th>Weight<br>(KG)</th>
		<th>Rate<br>(PKR)</th>
		<th>Discount<br>(PKR)</th>
		<th>Amount<br>(PKR)</th>
	<!--</tr>-->
	</thead>

<?php if($sales){?>
	<tbody class="purchaseRows" id="purchaseRows">
		 <?
			 $i=1;
			 $b=1;
			 $amtqty=0;
			 $akgqty=0;
			 $atdiscount=0;
			 $total_all_amount = 0;
			foreach($sales as $sale){
			?>
		<tr class="search_filter">
			<td colspan="10"><?php echo $sale['filter_text'];?></td>
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
				$tdiscount=0;
				$total_amount=0;
				foreach($sale['detail'] as $saledet){
					$mtqty=$mtqty + $saledet['fld_quantity'];
					$tdiscount+=$saledet['fld_discount'];
					$total_amount=$total_amount + $saledet['fld_total_amount']-$saledet['fld_discount'];
					$kgqty=$kgqty +$saledet['fld_weight'];
					if($filter_type == 1){
					    $subcat = '';
					    if($saledet['fld_subproduct_id'] != '0'){
					        $subcat = ' - '.$this->db->query("select * from tbl_subcategory where fld_subcid = '{$saledet['fld_subproduct_id']}'")->row()->fld_subcategory;
					    }
					?>
					<tr>
						<!--<td ><?//php echo $i;?></td>-->
						<td ><?php echo date('d-m-Y',strtotime($saledet['fld_sale_date']));?></td>
						<td ><?php echo $saledet['fld_voucher_no'];?></td>
						<td ><?php echo $saledet['fld_customer_name'];?></td>
						<td ><?php echo $saledet['fld_category'].$subcat;?></td>
						<td ><?php echo $saledet['fld_shipment'];?></td>
						<td ><?php echo $saledet['fld_quantity'];?></td>
						<td ><?php echo $saledet['fld_weight'];?></td>
						<td ><?php echo $saledet['fld_unit_price'];?></td>
						<td ><?php echo round($saledet['fld_discount'],2);?></td>
						<td ><?php echo round($saledet['fld_total_amount']-$saledet['fld_discount'],2);?></td>
					</tr>
					<?php $i++;
					}}
					?>
		<tr class="search_finalsum">
			<td colspan="5" style="text-align:right;font-weight:bold;">TOTAL</td>
			<td ><?= number_format($mtqty,2);?></td>
			<td ><?= number_format($kgqty,2);?></td>
			<td>&nbsp;</td>
			<td><?= number_format($tdiscount,2);?></td>
			<td><?= number_format($total_amount,2);?></td>
			<td style="display:none"></td>
			<td style="display:none"></td>
			<td style="display:none"></td>
			<td style="display:none"></td>
		</tr>
		<?php
		$total_all_amount += $total_amount;
		$atdiscount += $tdiscount;
		$akgqty += $kgqty;
		$amtqty += $mtqty;
		$b++;
		$counter = $i;
		} ?>
		
	</tbody>
	<tr class="tablebottom">
			<td colspan="5" style="text-align:right;font-weight:bold;">NET TOTAL</td>
			<td ><?= number_format($amtqty,2);?></td>
			<td ><?= number_format($akgqty,2);?></td>
			<td>&nbsp;</td>
			<td><?= number_format($atdiscount,2);?></td>
			<td><?= number_format($total_all_amount,2);?></td>
			<td style="display:none"></td>
			<td style="display:none"></td>
			<td style="display:none"></td>
			<td style="display:none"></td>
		</tr>
		<?php }else{?>
		<tr>
		    <td colspan="10" style="text-align:center;color:red;">Sorry No Record Found</td>
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
		<?php } ?>
</table>

<script>
    var table = $('#datatable_tb').DataTable({
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
