<div class="form-group">
    <select class="form-control" id="agreement_type" name="agreement_type" required>
        <option value=""  >--Agreement Type--</option>
        <? if($agreementtype->num_rows() > 0) {
            foreach($agreementtype->result() as $agreementtype_row) {
        ?>
            <option value="<?=$agreementtype_row->id?>" <? if($last_agreementtype_id == $agreementtype_row->id) { ?> selected <? } ?> ><?=$agreementtype_row->agreement_type; ?></option>
        <? } } ?>
    </select>
</div>	