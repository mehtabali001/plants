    <tr>
		<!--<td class="text-center">-->
		<!--  1-->
		<!--</td>-->

	<td class="text-center">
	    <?php if($product_id_selected==1){ ?>
	    <select class="select2 form-control mb-3 custom-select fld_product_id" name="fld_sitem[]" tabindex="8" id="product_subcat_1">
            <option value="0" data-weight="1000">LPG</option>
	    <?php }else{ ?>
		 <select class="select2 form-control mb-3 custom-select fld_product_id" name="fld_sitem[]" tabindex="8" onchange="check_sub_product()" id="product_subcat_1">
            <option value="">Select Product</option>
			<?php
			if($subcategory){
			foreach($subcategory as $cat){
			?>
			<option value="<?= $cat['fld_subcid'];?>" data-weight="<?= preg_replace('/[^0-9.]/', '', $cat['fld_subcategory']);?>"><?= $cat['fld_subcategory'];?></option>
			<?php }}?>
		</select>
		<?php } ?>
	</td>
	<td class="text-right">
	    <div class="input-group">
			<input type="text" class="form-control fld_shipment_from" name="fld_shipment_from[]" tabindex="9" value="" id="fld_shipment_1" readonly required>
			<span class="input-group-prepend">
				<button type="button" id="location_shipments_1" onclick="getShipments(1)" class="btn btn-gradient-primary"><i class="fas fa-search"></i></button>
			</span>
		</div>
		<input type="hidden" id="stock_location_id_1" name="stock_location_id[]" value=""/>
		<input type="hidden" id="fld_purchase_id_1" name="fld_purchase_id[]" value="" />
	</td>
	<td class="text-right">
        <input type="number" step="0.001" required name="fld_item_qty[]" id="cartoon_1" min="0" class="form-control text-right item_quantity" onkeyup="calculate_store(1);" onchange="calculate_store(1);" placeholder="0.00" value="" tabindex="10" aria-required="true"  onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false" oninput="validity.valid||(value='');">
    </td>
    <td class="text-right">
        <input type="number" name="fld_item_weight[]" id="fld_weight_1" class="form-control text-right" onkeyup="calculate_store(1);" onchange="calculate_store(1);" placeholder="0" value="0"  aria-required="true" readonly>
    </td>
    <td class="test">
        <input type="number" name="fld_rate[]" required="" onkeyup="calculate_store(1);" onchange="calculate_store(1);" id="product_rate_1" class="form-control product_rate_1 text-right" placeholder="0.00" value="" min="0"  aria-required="true" readonly>
    </td>
    <td class="text-right">
        <input class="form-control fld_amount_row text-right" type="number" name="fld_amount[]" id="total_price_1" value="0.00"  readonly="readonly">
    </td>
    <!--<td>-->
    <!--    <button class="btn btn-danger text-right red" type="button" value="Delete" onclick="deleteRow(this)" ><i class="fas fa-times"></i></button>-->
    <!--</td>-->
	</tr>
