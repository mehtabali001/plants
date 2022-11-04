<input type="hidden" id="selected_row_cat" value="0" />
<div class="table-responsive">
	<table class="table table mb-0">
		<thead>
		<tr>
			<th>#</th>
			<th>Shipment No</th>
			<th>Quantity(<?php if($product_id==1){ echo 'MT'; }else{ echo 'QTY';} ?>)</th>
			<th>Sales (<?php if($product_id==1){ echo 'KG'; }else{ echo 'QTY';} ?>)</th>
			<th>Action</th>
		</tr>
		</thead>
		<tbody>
		<?php if($shipments){
			$i=1;
		    $total_stock = 0;
		    $total_sale = 0;
		    $tq = 0;
			foreach($shipments as $ship){
			    $totalSale = 0;
			    $totalsaleq = $this->db->query("SELECT sc.fld_subcategory, sc.weight, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE  a.fld_location_id = '$location_id' AND b.fld_stock_location_id = '{$ship['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id && a.fld_isdeleted = 0")->result_array();
			    foreach($totalsaleq as $tsale){
			        if($product_id==1){
			            $totalSale += $tsale['weight']*$tsale['fld_quantity'];
			        }else{
			            $totalSale += $tsale['fld_quantity'];
			        }
                    
                }
                 
                if($product_id==1){
                    
                    $totalSale = round($totalSale/1000, 3);
                }
                
                $gl_diff = $this->db->query("SELECT IFNULL(SUM(fld_quantity), 0) as qty FROM tbl_gainloss_details WHERE fld_type = 3 && fld_stock_location_id = '{$ship['fld_id']}'")->row_array();
                $totalDiff = 0; 
                // echo $ship['fld_shipment'].' '.($ship['fld_stock_qty']-$totalSale).'<br>';
                $showqty = round((($ship['fld_stock_qty']-$totalSale)+$totalDiff), 3);
                // $showqty = round((($ship['fld_stock_qty'])+$totalDiff), 3);
                
                 if($showqty > 0){
                     if($ship['fld_id'] != 16 && $ship['fld_id'] != 18){
                $total_stock += $showqty;
                if($product_id==1){ $total_sale += ($totalSale*1000); }else{ $total_sale += $totalSale; }
			?>
			<tr>
				<td><?= $i;?></td>
				<td><?= $ship['fld_shipment'];?></td>
				<td style="text-align: center;"><?= $showqty;?></td>
				<td style="text-align: center;"><?php if($product_id==1){ echo $totalSale*1000; }else{ echo $totalSale; }?></td>
				<td><i class="mdi mdi-circle-edit-outline shipment" data-id="<?= $ship['fld_id'];?>" data-product="<?= $ship['fld_product_id'];?>" data-subproduct="<?= $ship['fld_subproduct_id'];?>" data-qty="<?= $ship['fld_stock_qty']-$totalSale;?>"  style="font-size: 22px;cursor: pointer;"></i></td>
			</tr>
			<?php $i++;}}} ?>
			<tr>
				<td colspan="2" style="text-align: right;font-weight:bold">Total Stock</td>
				<td style="text-align: center;font-weight:bold"><?=$total_stock;?></td>
				<td style="text-align: center;font-weight:bold"><?=$total_sale;?></td>
				<td style="text-align: center;font-weight:bold"></td>
			</tr>
			
			<?php }else{?>
			<tr>
				<td colspan="4" style="text-align: center;">No record found.</td>
			</tr>
			<?php }?>
		</tbody>
	</table><!--end /table-->
</div>
