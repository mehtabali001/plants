<style>

.search_filter td {
    border: none !important;
    background: #f1f5fa;
    color: #000;
    font-weight: bold;
}
.tootaal td{
    color:#000;
}
.search_finalsum td {
    border: none !important;
    /*background: rgb(245 222 179) !important;*/
        color: #000;
    font-weight: bold;
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
.btn-outline-primary{
    background:#fff;
    color:#000 ;
}
.btn-outline-primary:hover{
    background-color: #506ee4;
    border-color: #506ee4;
    color:#fff;
}
</style>
 <? if($expense){ ?>
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
				  <? //if(!empty($role_permissions) && in_array(164,$role_permissions)) { ?>
                        <a type="button" style="" id="print_report" class="btn btn-outline-primary  print_report" name="" value="" ><i class="fa fa-print" aria-hidden="true"></i>&nbsp;Print</a>
						<?// } ?>
						<? //if(!empty($role_permissions) && in_array(165,$role_permissions)) { ?>
                        <a type="button" style="" id="pdf_expense_report" class="btn btn-outline-primary pdf_expense_report" name="" value="" ><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;PDF</a>
                        <a type="button" id="" class="btn btn-outline-primary " disabled  onclick="downloadcsv();"><i class="fa fa-file-csv" aria-hidden="true"></i>&nbsp;CSV</a>
						<?// } ?>
						 
                </div>
			</div>
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<?}?>
<table id="datatable_3tb" class=" table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
	<thead class="dthead tabletop">
	<tr>
		<th>Expense Date</th>
		<th>Invoice ID</th>
		<th>Type </th>
		<th>Item - Qty</th>
		<th>Remarks</th>
		<th>Paid From</th>
		<th>Amount(PKR)</th>
	</tr>
	</thead>

	<tbody class="expenseRows" id="expenseRows">
		 <?php 
		 
		 if($expense){
			 $i=1;
			 $b=1;
			  $nettotal_amount=0;
			foreach($expense as $expens){
			   
			?>
		<tr class="search_filter">
			<td colspan="7" style="padding-left: 24%;"><?php echo $expens['filter_text'];?></td>
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
				foreach($expens['detail'] as $expensdet){
					$mtqty=$mtqty + $expensdet['quantity']; 	 
					$total_amount = $total_amount + $expensdet['unit_price'];
					if($filter_type == 1){
					   $unit = $this->Common_model->select_single_field('fld_unit','tbl_units',array('fld_id'=>$expensdet['st_unit']));
					   $plantfrom =	$this->Common_model->select_single_field('head_name','tbl_coa',array('head_code'=>$expensdet['plant_from']));
					   if($expensdet['expense_type'] == 1){
							$exptype = "Office Expense";
						}else{
							$exptype = "Mess Expense";
						}
						
						$nettotal_amount = $nettotal_amount + $expensdet['unit_price'];
					?>
					<tr>
						<td ><?php echo date('d-m-Y',strtotime($expensdet['date_added']));?></td>
						<td ><?php echo $expensdet['expense_voucher'];?></td>
						<td class="text-center"><?= $exptype ;?></td>
						<td ><?php echo $expensdet['st_name'].' '.'('.$expensdet['quantity'].' - '.$unit.')';?></td>
						<td ><?php if(!empty($expensdet['remarks'])){ echo $expensdet['remarks']; }else{ echo "Nil"; } ?></td>
						<td ><?php echo $plantfrom;?></td>
						<td ><?php echo $expensdet['unit_price'];?></td>
					</tr>
		<?php $i++; }}?>
		<tr class="search_finalsum tootaal">
			<td colspan="6" style="text-align:right;font-weight:bold;color:black;">TOTAL</td>
			<td><?= number_format($total_amount,2);?></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
		</tr>
		<?php
		$b++;
		}?>
		<tr class="search_finalsum tablebottom">
			<td colspan="6" style="text-align:right;font-weight:bold;">NET TOTAL</td>
			<td><?= number_format($nettotal_amount,2);?></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			
		</tr>
		<?php }else{?>
		<tr>
		    <td colspan="7" style="text-align:center;color:red;">Sorry No Record Found</td>
		    <td style="display:none;"></td>
		    <td style="display:none;"></td>
		    <td style="display:none;"></td>
		    <td style="display:none;"></td>
		    <td style="display:none;"></td>
		    <td style="display:none;"></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<script>
  
   function downloadcsv(){
        //  var form = $('#ledgerFilter').serialize();
        var formdata=$('#expensefilter').serialize();
       var url="<?php echo base_url(); ?>Expenses/filter_csv?"+formdata;
       window.open(url);
   }
</script>