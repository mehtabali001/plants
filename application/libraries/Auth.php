<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth {
    //Login....
    public function login($email,$password)
    {
        $CI =& get_instance();
        $CI->load->model('Users');
        $CI->load->model('Common_model');
        $result = $CI->Users->check_valid_user($email,$password);

        /*if($result[0]['user_type'] == 1){

            $checkPermission = $CI->Users->userPermissionadmin($result[0]['user_id']);
        }
        else{
            $checkPermission = $CI->Users->userPermission($result[0]['user_id']);
        }
        
        $permission = array();
        if(!empty($checkPermission))
            foreach ($checkPermission as $value) {
                $permission[$value->directory] = array(
                    'create' => $value->create,
                    'read'   => $value->read,
                    'update' => $value->update,
                    'delete' => $value->delete
                );
            }*/

        if ($result)
        {
            $key = md5(time());
            $key = str_replace("1", "z", $key);
            $key = str_replace("2", "J", $key);
            $key = str_replace("3", "y", $key);
            $key = str_replace("4", "R", $key);
            $key = str_replace("5", "Kd", $key);
            $key = str_replace("6", "jX", $key);
            $key = str_replace("7", "dH", $key);
            $key = str_replace("8", "p", $key);
            $key = str_replace("9", "Uf", $key);
            $key = str_replace("0", "eXnyiKFj", $key);
            $sid_web = substr($key, rand(0, 3), rand(28, 32));
            
            //$getpermissions = $this->db->query("SELECT * FROM tbl_roles WHERE role_id = '".$result[0]['fld_role']."'")->row();
			$getpermissions = $CI->Common_model->select_where_return_row('*','tbl_roles',array('role_id'=>$result[0]['fld_role']));
			$getempid = $CI->Common_model->select_where_return_row('*','tbl_users',array('emp_id'=>$result[0]['emp_id']));
			$empactivestatus = $getempid->emp_id;
			//echo $empactivestatus; exit;
			
			$permissions = $getpermissions->perm_issions;
        			$mainmenu = $getpermissions->admin_menu;
        			$sublevel = $getpermissions->admin_menu_sublevel;
        			$sublevellinks = $getpermissions->admin_menu_group;
                    
                    // codeigniter session stored data          
                    $user_data = array(
                        'sid_web'           => $sid_web,
                        'isLogIn'           => true,
                        'isAdmin'           => (($result[0]['fld_user_type'] == 1)?true:false),
                        'user_id'           => $result[0]['fld_id'],
                        'user_type'         => $result[0]['fld_user_type'],
                        'user_name'        => $result[0]['fld_username'],
                        'fld_email'         => $result[0]['fld_email'],
                        'user_otp'          => $result[0]['fld_OTP'],
                        'user_role'         => $result[0]['fld_role'],
                        'user_role_name'    => $getpermissions->role_name,
                        'emp_id'            => $result[0]['emp_id'],
        				'mainmenu'          => $mainmenu,
        				'sublevel'          => $sublevel,
        				'sublevellinks'     => $sublevellinks,
        				'permissions'       => $permissions,
                     // 'permission'        => json_encode($permission)
                    );
			
			if($empactivestatus == 0){
                $CI->session->set_userdata($user_data);
                return TRUE;
			}elseif($empactivestatus > 0){
			    
			    //$empemail = $CI->session->userdata('fld_email');
                //$userrole = $this->session->userdata('user_role');
                //$getemployeestatus = $CI->Common_model->select_where_return_row('*','tbl_employees',array('email'=>$email));
                
                $getemployeestatus =	$CI->Common_model->select_single_field('is_active','tbl_employees',array('email'=>$email));
 
                if($getemployeestatus == 1){
                    $CI->session->set_userdata($user_data);
                    return TRUE;
			    }else{
			        
			        return FALSE;   
			    }
		}
        }else{
            return FALSE;
        }
    }
    //Check if is logged....
    public function is_logged()
    {
        $CI =& get_instance();
        if($CI->session->userdata('sid_web'))
        {
            return true;
        }
        return false;
    }
    //Logout....
    public function logout()
    {
        $CI =& get_instance();
        $user_data = array(
                'sid_web','isLogIn','isAdmin','user_id','user_type','user_name','fld_email','user_otp','user_role','emp_id','mainmenu','sublevel','sublevellinks','permissions'
            );
        $CI->session->unset_userdata($user_data);
        return true;
    }
    //Check for logged in user is Admin or not.
    
    public function is_admin()
    {
        // || $CI->session->userdata('user_type')==2
        $CI =& get_instance();
        if ($CI->session->userdata('user_type')==1)
        {
            return true;
        }
        return true;
    }
    function check_admin_auth($url='')
    {   
        if($url==''){$url = base_url().'Admin_dashboard/login';}
        $CI =& get_instance();
        if ((!$this->is_logged()) || (!$this->is_admin()))
        { 
            $this->logout();
            $error = "You are not authorized for this part";
            $CI->session->set_userdata(array('error_message'=>$error));
            redirect($url,'refresh'); exit;
        }
    }
    
    //This function is used to Generate Key
    public function generator($lenth)
    {
        $number=array("A","B","C","D","E","F","G","H","I","J","K","L","N","M","O","P","Q","R","S","U","V","T","W","X","Y","Z","1","2","3","4","5","6","7","8","9","0");
    
        for($i=0; $i<$lenth; $i++)
        {
            $rand_value=rand(0,34);
            $rand_number=$number["$rand_value"];
        
            if(empty($con))
            { 
            $con=$rand_number;
            }
            else
            {
            $con="$con"."$rand_number";}
        }
        return $con;
    }

}



?>