<div class="form-group">
    <select class="form-control" id="designation" name="designation" required>
        <option value=""  >--Select Designation--</option>
        <? if($designation->num_rows() > 0) {
            foreach($designation->result() as $desig) {
        ?>
            <option value="<?=$desig->id?>" <? if($last_designation_id == $desig->id) { ?> selected <? } ?> ><?=$desig->designation_name; ?></option>
        <? } } ?>
    </select>
</div>