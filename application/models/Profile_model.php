<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Profile_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function getMaxprofileID() {
		$sql="SHOW TABLE STATUS LIKE 'tbl_users'";
		return $this->db->query($sql)->row_array();
     // $this->db->select('Max(fld_id) as maxid');
     // return $this->db->get('tbl_suppliers')->row_array();
    }
    
  
   
}
