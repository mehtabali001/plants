<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Base_model extends CI_Model {

    // Get All Records
    function getAll($tableName, $columnName='', $condition='', $toString='')
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
	function getRow($tableName, $columnName='', $condition='', $toString='')
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

        return $query->row_array();
    }

    function insert($tableName, $data, $toString='')
    {
        foreach ($data as $key=>$val) {
            $this->db->set($key,$val);
        }

        $this->db->insert($tableName);

        if ($toString){
            $this->getQuery();
        }

        return $this->db->insert_id();
    }

    // Update Records
    function update($tableName, $data, $condition, $excludedField='', $toString='')
    {
        foreach ($data as $key=>$val) {
            if ($key != $excludedField) {
                $this->db->set($key, $val);
            }
        }

        $this->db->where($condition);

        return $this->db->update($tableName);

        if ($toString){
            $this->getQuery();
        }
    }

    // Delete Records
    function delete($tableName, $condition)
    {
        $this->db->where($condition);

        return $this->db->delete($tableName);
    }

    // Return query as a string
    function getQuery()
    {
        die($this->db->last_query());
    }
	
	// Truncate Table
    function truncate($tableName)
    {
        $this->db->truncate($tableName);
    }

    // Check if there is a file
    function hasFile($fieldName)
    {

    }

    function get_autoincrement_id($tableName,$toString='')
    {
        $this->db->select('AUTO_INCREMENT');

        $this->db->from('INFORMATION_SCHEMA.TABLES');

        $this->db->where('TABLE_SCHEMA',$this->db->database);

        $this->db->where('TABLE_NAME',$tableName);

        $query = $this->db->get();

        if ($toString){
            $this->getQuery();
        }

        $array = $query->result_array();

        return $array[0]['AUTO_INCREMENT'];
    }
    
    function getLocation($ip){
          $geolocation = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip));
          return $geolocation['geoplugin_city'].', '.$geolocation['geoplugin_countryName'];
    }
    
    function systemInfo()
     {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $os_platform    = "Unknown OS Platform";
        $os_array       = array('/windows nt 10.0/i'    =>  'Windows 10',
                                '/windows phone 8/i'    =>  'Windows Phone 8',
                                '/windows phone os 7/i' =>  'Windows Phone 7',
                                '/windows nt 6.3/i'     =>  'Windows 8.1',
                                '/windows nt 6.2/i'     =>  'Windows 8',
                                '/windows nt 6.1/i'     =>  'Windows 7',
                                '/windows nt 6.0/i'     =>  'Windows Vista',
                                '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                                '/windows nt 5.1/i'     =>  'Windows XP',
                                '/windows xp/i'         =>  'Windows XP',
                                '/windows nt 5.0/i'     =>  'Windows 2000',
                                '/windows me/i'         =>  'Windows ME',
                                '/win98/i'              =>  'Windows 98',
                                '/win95/i'              =>  'Windows 95',
                                '/win16/i'              =>  'Windows 3.11',
                                '/macintosh|mac os x/i' =>  'Mac OS X',
                                '/mac_powerpc/i'        =>  'Mac OS 9',
                                '/linux/i'              =>  'Linux',
                                '/ubuntu/i'             =>  'Ubuntu',
                                '/iphone/i'             =>  'iPhone',
                                '/ipod/i'               =>  'iPod',
                                '/ipad/i'               =>  'iPad',
                                '/android/i'            =>  'Android',
                                '/blackberry/i'         =>  'BlackBerry',
                                '/webos/i'              =>  'Mobile');
        $found = false;
        
        $device = '';
        foreach ($os_array as $regex => $value) 
        { 
            if($found)
             break;
            else if (preg_match($regex, $user_agent)) 
            {
                $os_platform    =   $value;
                $device = !preg_match('/(windows|mac|linux|ubuntu)/i',$os_platform)
                          ?'':(preg_match('/phone/i', $os_platform)?'':'');
            }
        }
        $device = !$device? '':$device;
        // array('os'=>$os_platform,'device'=>$device);
        return "$device $os_platform";
     }

     public static function browser() 
     {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
    
        $browser        =   "Unknown Browser";
    
        $browser_array  = array('/msie/i'       =>  'Internet Explorer',
                                '/firefox/i'    =>  'Firefox',
                                '/safari/i'     =>  'Safari',
                                '/chrome/i'     =>  'Chrome',
                                '/opera/i'      =>  'Opera',
                                '/netscape/i'   =>  'Netscape',
                                '/maxthon/i'    =>  'Maxthon',
                                '/konqueror/i'  =>  'Konqueror',
                                '/mobile/i'     =>  'Handheld Browser');
                                
                                $found = false;
    
        foreach ($browser_array as $regex => $value) 
        { 
            if($found)
             break;
            else if (preg_match($regex, $user_agent,$result)) 
            {
                $browser    =   $value;
            }
        }
        return $browser;
     }

}