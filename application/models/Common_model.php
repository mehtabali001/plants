<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function getMaxsuplierID() {
		$sql="SHOW TABLE STATUS LIKE 'tbl_suppliers'";
		return $this->db->query($sql)->row_array();
     // $this->db->select('Max(fld_id) as maxid');
     // return $this->db->get('tbl_suppliers')->row_array();
        
    }
    
    function select_all($select,$table)
	{
		$this->db->select( $select );
		$this->db->from( $table );
		return $this->db->get();
	}
	
	function select_where($select,$table,$where)
	{
		$this->db->select( $select );
		$this->db->from( $table );
		$this->db->where( $where );
		return $this->db->get();
	}

    function select_single_field($select,$table,$where)
	{
		$this->db->select( $select );
		$this->db->from( $table );
		$this->db->where( $where );
		$qry = $this->db->get();
		$rr	=	$qry->row_array();
		if(!empty($rr))
		return	$rr[$select];
	    //return FALSE;
    }
    
    function select_where_table_rows($select,$table,$where)
	{
		$this->db->select( $select );
		$this->db->from( $table );
		$this->db->where( $where );
		$query=$this->db->get();
		return $query->num_rows();
	}
	
	function select_where_return_row($select,$table,$where)
	{
		$this->db->select( $select );
		$this->db->from( $table );
		$this->db->where( $where );
		$query=$this->db->get();
		return $query->row();
	}
	
	function select_limit($select,$table,$page,$recordperpage)
	{
		$this->db->select( $select );
		$this->db->from( $table );
		$this->db->limit( $recordperpage , $page );
		$result=$this->db->get();
		return $result;
	}

	
	function select_table_rows($select,$table)
	{
		$this->db->select( $select );
		$this->db->from( $table );
		$query=$this->db->get();
		return $query->num_rows();
	}
    
    function select_where_ASC_DESC( $select,$table,$where,$orderBy_columName,$ASC_DESC )
	{
		$this->db->select( $select );
		$this->db->from( $table );
		$this->db->where( $where );
		$this->db->order_by( $orderBy_columName , $ASC_DESC );
		$result=$this->db->get();
		//return $result->result_array();
		return $result;	
	}
	
	// Get All rows Records
    function getAllrows($tableName, $columnName='', $condition='', $toString='')
    {
        if (!$columnName) {
            $this->db->select('*');
        }else{
            $this->db->select($columnName);
        }
        $this->db->from($tableName);
        if ($condition){
            $this->db->where($condition);
        }
        $query = $this->db->get();
        if ($toString){
            $this->getQuery();
        }
        return $query->result_array();
    }
	
	function select_join(){
		$this->db->select('*');
		$this->db->from('tbl_attendance');
		$this->db->join('tbl_employees', 'tbl_employees.id = tbl_attendance.user_id');
		$query = $this->db->get();
		return $query->row_array();
    }
	
	function update_array($where,$table,$data)
	{
		$this->db->where( $where );
		$this->db->update( $table , $data);	
	}
	
	function insert_array($table,$data)
	{
		$this->db->insert( $table,$data );
		return $this->db->insert_id();	
	}
	
	function delete_where($where,$tbl_name)
	{
		$this->db->where($where);
		$this->db->delete($tbl_name);
	}
    
   
}
