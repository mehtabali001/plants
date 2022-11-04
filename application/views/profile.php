
<div class="container-fluid">
    <div class="row">
    	<div class="col-sm-12">
    		<div class="page-title-box">
    			<div class="float-right">
    				<ol class="breadcrumb">
    					<li class="breadcrumb-item"><a href="javascript:void(0);">ERP</a></li>
    					<li class="breadcrumb-item active">View Profile</li>
    				</ol>
    			</div>
    			<h4 class="page-title">View Profile</h4>
    		</div><!--end page-title-box-->
    	</div><!--end col-->
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label text-right">Name</label>
            <div class="col-sm-10">
                <input class="form-control" type="text" value="<?= @$users['fld_username'];?>" id="example-text-input" disabled>
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label text-right">First Name</label>
            <div class="col-sm-10">
                <input class="form-control" type="text" value="<?= @$users['fld_first_name'];?>" id="example-text-input" disabled>
            </div>
        </div>
        
        <div class="form-group row">
            <label for="example-password-input" class="col-sm-2 col-form-label text-right">Password</label>
            <div class="col-sm-10">
                <input class="form-control" type="password" value="<?= @$users['fld_password'];?>" id="example-password-input"disabled>
            </div>
        </div>
        <div class="form-group row">
            <label for="example-password-input" class="col-sm-2 col-form-label text-right">Profile Image</label>
            <div class="col-sm-10">
                <input type="file" id="input-file-now-custom-1" class="dropify" data-default-file="../assets/images/users/user-4.jpg" >
            </div>
        </div>
        
                                
    </div>
    <div class="col-lg-6">
        
        <div class="form-group row">
            <label for="example-email-input" class="col-sm-2 col-form-label text-right">Email</label>
            <div class="col-sm-10">
                <input class="form-control" type="email" value="bootstrap@example.com" id="example-email-input" disabled>
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label text-right">Last Name</label>
            <div class="col-sm-10">
                <input class="form-control" type="text" value="<?= @$users['fld_last_name'];?>" id="example-text-input" disabled>
            </div>
        </div>
        <div class="form-group row">
            <label for="example-tel-input" class="col-sm-2 col-form-label text-right">Telephone</label>
            <div class="col-sm-10">
                <input class="form-control" type="tel" value="<?= @$users['fld_phone'];?>" id="example-tel-input" disabled>
            </div>
        </div>                                
    </div>
</div> 