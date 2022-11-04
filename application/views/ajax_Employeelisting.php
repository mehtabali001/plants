<?php 
    if($attendance){
                    foreach($attendance as $emp){ 
                    $designation =	$this->Common_model->select_single_field('designation_name','tbl_designation',array('id'=>$emp['designation']));       
                    //$department  =	$this->Common_model->select_single_field('department_name','tbl_departments',array('id'=>$emp['department']));
					$plant       =	$this->Common_model->select_single_field('name','tbl_plants',array('id'=>$emp['plants']));
					$name        =	$this->Common_model->select_single_field('full_name','tbl_employees',array('id'=>$emp['user_id']));
   ?>
                        <tr>
                            <td><?php echo date("d-M-Y",strtotime($emp['attendance_date']));?></td>
                            <td><?=$name;?></td>
							<td><?=$plant;?></td>
                            <td><?=$designation;?></td>
							<td><?=$emp['check_in'];?> AM</td>
							<td><?=$emp['check_out'];?> PM</td>
                            <?php /* ?>
                            <td>
							<?php 
							if($emp['fld_supplier_type'] == 1){
                                echo 'Local';
                            }elseif($emp['fld_supplier_type'] == 2){
                                echo 'Importer';
                            }else{
                                echo '';
                            } 
							?>
                            </td>
							<?php */ ?>
                            <td>
                            <!--<a href="#openModal1">-->
                            <!--<i style="font-size:20px;cursor:pointer;" class="mdi mdi-square-edit-outline" title="Edit"></i></a>-->
                           </td>
        </tr>
	<?php }}else {?>
<tr>
    <td colspan="7"><br><p style="color:#900;" >Sorry No Record Found!</p></td>
</tr>
<? } ?>