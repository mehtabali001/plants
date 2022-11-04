<?php if($item_id==1){ ?>
<div class="table-responsive">
	<table class="table table mb-0">
		<thead>
		<tr>
			<th>#</th>
			<th>Shipment No</th>
			<th>Quantity(MT)</th>
			<th>Sales (KG)</th>
			<th>Action</th>
		</tr>
		</thead>
		<tbody>
		<?php if($shipments){
			$i=1;
			foreach($shipments as $ship){
			    $totalSale = 0;
			    $totalsale = $this->db->query("SELECT sc.fld_subcategory, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE  a.fld_location_id = '$location_id' AND a.fld_stock_location_id = '{$ship['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id")->result_array();
			    foreach($totalsale as $tsale){
                    $totalSale += preg_replace('/[^0-9.]/', '', $tsale['fld_subcategory'])*$tsale['fld_quantity'];
                }
                $totalSale = round($totalSale/1000, 3);
			?>
			<tr>
				<td><?= $i;?></td>
				<td><?= $ship['fld_shipment'];?></td>
				<td><?= $ship['fld_stock_qty']-$totalSale;?></td>
				<td><?=$totalSale*1000;?></td>
				<td><i class="mdi mdi-circle-edit-outline shipment" data-id="<?= $ship['fld_id'];?>" data-product="<?= $ship['fld_product_id'];?>" style="font-size: 22px;cursor: pointer;"></i></td>
			</tr>
			<?php $i++;}}else{?>
			<tr>
				<td colspan="4" style="text-align: center;">No record found.</td>
			</tr>
			<?php }?>
		</tbody>
	</table><!--end /table-->
</div>
<?php }else{ ?>
<div class="table-responsive">
	<table class="table table mb-0">
		<thead>
		<tr>
			<th>#</th>
			<th>Shipment No</th>
		</tr>
		</thead>
		<tbody>
		<?php if($shipments){
			$i=1;
			$shipment_array = array();
			foreach($shipments as $ship){
			    $totalSale = 0;
			    $totalsale = $this->db->query("SELECT sc.fld_subcategory, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE  a.fld_location_id = '$location_id' AND a.fld_stock_location_id = '{$ship['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id")->result_array();
			    foreach($totalsale as $tsale){
                    $totalSale += preg_replace('/[^0-9.]/', '', $tsale['fld_subcategory'])*$tsale['fld_quantity'];
                }
                $totalSale = round($totalSale/1000, 3);
                if(!in_array($ship['fld_shipment'], $shipment_array)){
                    array_push($shipment_array,$ship['fld_shipment']);
			?>
			<tr>
				<td><?= $i;?></td>
				<td><?= $ship['fld_shipment'];?></td>
				</tr>
			<tr>
			    <td colspan="1"></td>
			    <td colspan="1"><table class="table table mb-0">
		        <thead>
		            <tr>
		                <th>Item</th>
		                <th>Quantity</th>
		                <th>Sale</th>
		                <th>Action</th>
		            </tr>
		        </thead>
    		<tbody>
    		    <?php  	
    		    foreach($shipments as $ship1){
			    $totalSale = 0;
			    $totalsale = $this->db->query("SELECT sc.fld_subcategory, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE  a.fld_location_id = '$location_id' AND a.fld_stock_location_id = '{$ship1['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id")->result_array();
			    foreach($totalsale as $tsale){
                    $totalSale += preg_replace('/[^0-9.]/', '', $tsale['fld_subcategory'])*$tsale['fld_quantity'];
                }
                $totalSale = round($totalSale/1000, 3);
                if($ship1['fld_shipment']==$ship['fld_shipment']){
                $subcat = '';
			    if($ship1['fld_subproduct_id'] != '0'){
			        $subcat = $this->db->query("select * from tbl_subcategory where fld_subcid = '{$ship1['fld_subproduct_id']}'")->row()->fld_subcategory;
			    }?>
    		    <tr>
        		    <td><?= $subcat;?></td>
        		    <td><?= $ship1['fld_stock_qty']-$totalSale;?></td>
        		    <td><?=$totalSale*1000;?></td>
        		    <td><td><i class="mdi mdi-circle-edit-outline shipment" data-id="<?= $ship1['fld_id'];?>" data-product="<?= $ship1['fld_product_id'];?>"  style="font-size: 22px;cursor: pointer;"></i></td></td>
    		    </tr>
    		    <?php }} ?>
		    </tbody>
			</table></td>
			</tr>
			<?php $i++;}}}else{?>
			<tr>
				<td colspan="4" style="text-align: center;">No record found.</td>
			</tr>
			<?php } ?>
		</tbody>
	</table><!--end /table-->
</div>
<?php } ?>