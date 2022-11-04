
<div class="container-fluid">
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Employees" type="button" class="btn btn-outline-primary"><i class='fas fa-user-plus'></i>&nbsp;New Employee</a>
                  <a href="<?= base_url();?>Employees/manage_Employees" type="button" class="btn btn-outline-primary"><i class='fa fa-eye'></i>&nbsp;View Employee</a>
                  <a href="<?= base_url();?>Employees/employee_report" type="button" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;Employees Report</a>
                  <a href="<?= base_url();?>Employees/manage_trash" type="button" class="btn btn-outline-primary"><i class="fa fa-trash"></i>&nbsp;Trashed Employees</a>
                </div>
			</div>
			<!--<h4 class="page-title">View Employee</h4>-->
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
</div>
<div class="cv container">
    <?php 
        $designation =	$this->Common_model->select_single_field('designation_name','tbl_designation',array('id'=>$employees['designation']));       
        $department =	$this->Common_model->select_single_field('department_name','tbl_departments',array('id'=>$employees['department']));
        $religion =	$this->Common_model->select_single_field('religion_name','tbl_religion',array('id'=>$employees['religion']));
        $agreement_type =	$this->Common_model->select_single_field('agreement_type','tbl_agreementtype',array('id'=>$employees['agreement_type']));
        $shift_group =	$this->Common_model->select_single_field('shift_name','tbl_shifts',array('id'=>$employees['shift_group']));
        $bankname =	$this->Common_model->select_single_field('fld_bank','tbl_banks',array('fld_id'=>$employees['bank_name']));
    ?>
  <div class="row">
    <div class="Col-md-6 col-lg-6 col-sm-12">
      <div class="cv-name"><?= (@$employees['full_name'] != "")?$employees['full_name']:'NA';?></div>
      <div class="id"><?= @$employees['employee_code'];?></div>
      <div class="status">Date of Birth: <?= @$employees['dob'];?></div>
      <hr>
      <div class="cv-content">
        <div class="title">Record</div>
        <div class="cv-content-item">
          <div class="status">Staff ID: <?= @$employees['employee_code'];?> </div>
          <div class="time">Date: <?= @$employees['date'];?></div>
          <div class="status">Type: <?//= @$employees['employee_type'];?>
          <?php if($employees['employee_type'] == 1){
                                echo 'Contract Based';
                            }elseif($employees['employee_type'] == 2){
                                echo 'Permanent';
                            }else{
                                echo '';
                            } ?>
          </div>
          <div class="status">Agreement Type: <?= $agreement_type;?></div>
          <div class="status">Department: <?=$department;?></div>
          <div class="status">Designation: <?=$designation;?></div>
        </div>
      </div><hr>
      <div class="cv-content">
        <div class="title">Personal Info</div>
        <div class="cv-content-item">
          <div class="status">Full Name: <?= @$employees['full_name'];?> </div>
          <div class="status">Father/Husband Name: <?= @$employees['f_hus_name'];?></div>
          <div class="status">Gender: <?//= @$employees['gender'];?>
            <?php if($employees['gender'] == 1){
                                echo 'Male';
                            }elseif($employees['gender'] == 2){
                                echo 'Female';
                            }else{
                                echo '';
                            } ?>
          </div>
          <div class="status">Marital Status: <?//= @$employees['marital_status'];?>
          <?php if($employees['marital_status'] == 1){
                                echo 'married';
                            }elseif($employees['marital_status'] == 2){
                                echo 'unmarried';
                            }else{
                                echo '';
                            } ?>
          </div>
          <div class="status">Religion: <?= $religion;?></div>
          <div class="status">Cnic: <?= @$employees['cnic'];?></div>
          <div class="time">Date of Birth: <?= @$employees['dob'];?></div>
          <div class="time">Date of Joining: <?= @$employees['joining_date'];?></div>
        </div>
      </div><hr>
      <div class="cv-content">
        <div class="title">Contact Details</div>
        <div class="cv-content-item">
          <div class="status">Address: <?= @$employees['address'];?> </div>
          <div class="status">Mobile No: <?= @$employees['mobile_no'];?></div>
          <div class="status">Phone No: <?= @$employees['phone_no'];?></div>
          <div class="status">Emergency Contact: <?= @$employees['emergency_contact'];?></div>
        </div>
      </div><hr>
      <div class="cv-content">
        <div class="title">Bank Details</div>
        <div class="cv-content-item">
          <div class="status">Account No: <?= @$employees['account_no'];?> </div>
          <div class="status">Bank Name: <?=$bankname;?></div>
          <div class="status">Salary: <?= @$employees['salary'];?></div>
        </div>
      </div><hr>
      <div class="cv-content">
        <div class="title">Shift Information</div>
        <div class="cv-content-item">
          <div class="status">Shift Group: <?=$shift_group;?></div>
          <div class="time">Shift Date: <?= @$employees['shift_date'];?></div>
        </div>
      </div>
      
    </div>
    <div class="Col-md-6 col-lg-6 col-sm-12">
      <div class="avatar">
        <img src="<?=base_url()?>/assets/uploads/profile_pictures/thumbs/s_<?=$employees['picture'];?>" alt="avatar" />
      </div><hr>
      <div class="cv-content">
        <div class="title">Contact</div>
        <div class="subtitle"><a>Address: <?= @$employees['address'];?></a></div>
        <div class="subtitle"><a href="tel:<?= (@$employees['mobile_no'] != "")?@$employees['mobile_no']:'NA';?>">Mobile: <?= (@$employees['mobile_no'] != "")?@$employees['mobile_no']:'NA';?></a></div>
        
      </div><hr>
      <div class="cv-content">
        <div class="title">Last Job Experience</div>
        <div class="cv-content-item">
          <div class="status">Previous Company Name: <?= @$employees['job_held'];?> </div>
          <div class="time">Start Time: <?= @$employees['job_start_date'];?></div>
          <div class="time">End Time: <?= @$employees['job_end_date'];?></div>
          <div class="status">Last Pay Draw: <?= @$employees['pay_draw'];?></div>
        </div>
      </div><hr>
      <div class="cv-content">
        <div class="title">Last Degree</div>
        <div class="cv-content-item">
          <div class="status">Degree Name: <?= @$employees['degree_name'];?></div>
          <div class="status">Degree Level: <?= @$employees['degree_level'];?></div>
          <div class="time">Start Time: <?= @$employees['degree_start_date'];?></div>
          <div class="time">End Time: <?= @$employees['degree_end_date'];?></div>
          <div class="status">Major Subjects: <?= @$employees['major_subjects'];?></div>
        </div>

      </div>
      
    </div>

  </div>

</div>