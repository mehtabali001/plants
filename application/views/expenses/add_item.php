<? /* ?><div class="form-group">
    <select class="select2 form-control mb-3 custom-select" id="fld_expense_id_<?=$row_id;?>" name="fld_expense_id[]" required="required">
        <option value="">--Select Item--</option>
        <? if($items->num_rows() > 0) {
           foreach($items->result() as $itm) {
        ?>
        <option value="<?=$itm->id?>" <? if($last_item_id == $itm->id) { ?> selected <? } ?> ><?=$itm->name; ?></option>
        <? } } ?>
    </select>
</div><? */ ?>

<div class="form-group">
    <select class="select2 form-control mb-3 custom-select" id="fld_expense_id_<?=$row_id;?>" name="fld_expense_id[]"  onchange="filled_units(<?=$row_id;?>);" required="required">
        <option value="">--Select Item--</option>
        <? //if($items->num_rows() > 0) {
           foreach($items as $itm) {
        ?>
        <option value="<?=$itm['id'];?>"  data-unit="<?= $itm['fld_unit'];?>" <? if($last_item_id == $itm['id']) { ?> selected <? } ?> ><?=$itm['name']; ?></option>
        <? }  ?>
    </select>
</div>