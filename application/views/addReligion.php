<div class="form-group">
    <select class="form-control" id="religion" name="religion" required>
        <option value=""  >--Select Religion--</option>
        <? if($religion->num_rows() > 0) {
            foreach($religion->result() as $relig) {
        ?>
            <option value="<?=$relig->id?>" <? if($last_religion_id == $relig->id) { ?> selected <? } ?> ><?=$relig->religion_name; ?></option>
        <? } } ?>
    </select>
</div>