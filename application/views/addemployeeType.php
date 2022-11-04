<div class="form-group">
    <select class="form-control" id="employee_type" name="employee_type" required>
        <option value=""  >--Employee Type--</option>
        <? if($employeetype->num_rows() > 0) {
            foreach($employeetype->result() as $employeetype_row) {
        ?>
            <option value="<?=$employeetype_row->id?>" <? if($last_type_id == $employeetype_row->id) { ?> selected <? } ?> ><?=$employeetype_row->type_name; ?></option>
        <? } } ?>
    </select>
</div>	