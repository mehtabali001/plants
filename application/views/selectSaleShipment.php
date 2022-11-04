
	<tr>
		<td class="text-center">
		  1
		</td>

	<td class="text-center">
		 <select class="select2 form-control mb-3 custom-select fld_product_id" name="fld_subcat_id[]" onchange="product_category(1);" tabindex="8" id="product_subcat_1" required>
            <option value="">Select Product</option>
			<?php
			if($subcategory){
			foreach($subcategory as $cat){
			?>
			<option value="<?= $cat['fld_subcid'];?>" data-weight="<?=$cat['weight'];?>"><?= $cat['fld_subcategory'];?></option>
			<?php }}?>
		</select>
	</td>
	<td class="text-right">
	    <div class="input-group">
			<input type="text"  class="form-control fld_shipment" name="fld_shipment[]" value="" id="fld_shipment_1" readonly required>
			<span class="input-group-prepend">
				<button type="button" tabindex="9" id="location_shipments_1" onclick="getShipments(1)" class="btn btn-gradient-primary"><i class="fas fa-search"></i></button>
			</span>
		</div>
		<input type="hidden" id="stock_location_id_1" name="stock_location[]" value=""/>
	</td>
	<td class="text-right">
	    <input type="hidden" name="orignal_qty[]" id="orignal_qty_1" />
        <input type="number" step="0.001" required name="fld_quantity[]" id="cartoon_1" min="0" class="form-control text-right fld_quantity"tabindex="10" onkeyup="calculate_store(1);" onchange="calculate_store(1);" placeholder="0.00" value="1" tabindex="8" aria-required="true" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false" oninput="validity.valid||(value='');">
    </td>
    <td class="text-right">
        <input type="number" value="0.00" name="fld_weight[]" id="fld_weight_1" class="form-control text-right" onkeyup="calculate_store(1);" onchange="calculate_store(1);" placeholder="0" value="0" aria-required="true" readonly onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false" oninput="validity.valid||(value='');">
        <input type="hidden" name="fld_row_discount[]" id="fld_row_discount_1" class="form-control text-right"  readonly>
    </td>
    <td class="test">
        <input type="number" name="fld_unit_price[]" required onkeyup="calculate_store(1);" onchange="calculate_store(1);" id="product_rate_1" class="form-control product_rate_1 text-right" placeholder="0.00" value="" min="1"  aria-required="true" readonly onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false" oninput="validity.valid||(value='');" pattern="[0-9]" onkeypress="return !(event.charCode == 46)"> 
    </td>
    <td class="text-right">
        <input class="form-control total_price text-right" type="number" name="fld_total_amount[]" id="total_price_1" value="0.00"  readonly="readonly">
    </td>
    <td>
        <button class="btn btn-danger text-right red" type="button" value="Delete" onclick="deleteRow(this)" ><i class="fas fa-times"></i></button>
    </td>
	</tr>
	
	<!--<input type="hidden" name="purchase_id" value="<?= $shipments['fld_purchase_id']?>"/>-->
