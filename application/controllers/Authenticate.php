<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authenticate extends CI_Controller
{
    private $username = "phed_user";

    private $password = "phed_password";

    public function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->helper(array('url','form'));

        $this->load->library(array('session' , 'user_agent'));

        $this->load->model('Apis_model');
    }

    public function index()
    {
       
        $username = $_POST['username'];
        $password = $_POST['password'];
        $device_id =$_POST['device_id'];
        if(filter_var($username, FILTER_VALIDATE_EMAIL)) {
			$isemail = $username;
		}else {
			$isUsename = $username;
		}

        if (count($_POST) > 0) {
            if(isset($isemail)){
			    $condition = array(
                'fld_email' => $username,
                'fld_password' => md5("kotal" .$password)
            );
            }else{
               $condition = array(
                'fld_username' => $username,
                'fld_password' => md5("kotal" .$password)
            ); 
            }
			$res = $this->Apis_model->check_login('tbl_users', $condition);
			if(count($res) > 0) {
				$access_token = md5(uniqid($device_id, true));
                $this->Apis_model->insert("tbl_access_token", array(
                    "token_key" => $access_token,
                    "device_id" => $device_id,
                    "token_valid" => 1
                ));
				return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(200)
                    ->set_output(json_encode(array(
                        'type'  => 'success',
                        'status' => '200',
                        'message' => 'Authentication Successful.',
                        'token' => $access_token
                    )));
			} else {
				return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(500)
                    ->set_output(json_encode(array(
                        'type'  => 'error',
                        'status' => '250',
                        'message' => 'Invalid username/password.',
                    )));
			}
        }else{
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(500)
                ->set_output(json_encode(array(
                    'type'  => 'error',
                    'status' => '300',
                    'message' => 'Authentication request could not be empty.',
                )));
        }
    }
}
