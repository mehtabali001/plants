<div class="form-group">
    <select class="select2 form-control mb-3 custom-select" id="department" name="department" required>
        <option value=""  >--Select Department--</option>
        <? if($departments->num_rows() > 0) {
            foreach($departments->result() as $depart) {
        ?>
            <option value="<?=$depart->id?>" <? if($last_department_id == $depart->id) { ?> selected <? } ?> ><?=$depart->department_name; ?></option>
        <? } } ?>
    </select>
</div>