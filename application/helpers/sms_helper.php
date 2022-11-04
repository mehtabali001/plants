<?php

defined('BASEPATH') OR exit('No direct script access allowed');

function send_sms($mobilenumber,$api_data,$message)
{
	$loginid="";
	$loginpass="";
	$mask="";

	if($api_data->fld_login_id != "" && $api_data->fld_login_pass != "" && $api_data->fld_message_body != ""){
	$loginid=$api_data->fld_login_id;
	$loginpass=$api_data->fld_login_pass;
	//$message=$api_data->fld_message_body;
	$mask=$api_data->fld_mask;
	if($mask == ""){
		$mask="Prime Gas";
	}
	if($message == ""){
	$message=$api_data->fld_message_body;
	}
	$message=strip_tags($message);
    $CI =& get_instance();
	$url="http://cbs.zong.com.pk/reachcwsv2/corporatesms.svc?wsdl";
	$client=new SoapClient($url);
	$result=$client->QuickSMS(array('obj_QuickSMS' => array('loginId'=>"$loginid",'loginPassword'=>"$loginpass",'Destination'=>"$mobilenumber",'Mask'=>"Prime Gas",'Message'=>"$message",'UniCode'=>'0','ShortCodePrefered'=>'n')));
	//echo '<pre>';
//	print_r($result);
//	print_r($mask);
//	print_r($message);
//	exit;
	}
}


