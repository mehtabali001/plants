<div class="form-group">
    <select class="form-control" id="shift_group" name="shift_group" required>
        <option value=""  >--Select Shift--</option>
        <? if($shift_group->num_rows() > 0) {
            foreach($shift_group->result() as $shift) {
        ?>
            <option value="<?=$shift->id?>" <? if($last_shift_id == $shift->id) { ?> selected <? } ?> ><?=$shift->shift_name; ?></option>
        <? } } ?>
    </select>
</div>