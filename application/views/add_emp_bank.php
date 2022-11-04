<div class="form-group">
    <select class="form-control" id="fld_bank" name="fld_bank">
        <option value="">--Select Bank--</option>
        <? if($banks->num_rows() > 0) {
           foreach($banks->result() as $bank) {
        ?>
        <option value="<?=$bank->fld_id?>" <? if($last_bank_id == $bank->fld_id) { ?> selected <? } ?> ><?=$bank->fld_bank; ?></option>
        <? } } ?>
    </select>
</div>