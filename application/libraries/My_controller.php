<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_controller extends CI_Controller
{
    public $title = "ERP";

    public $Gen;

    public function __construct()
    {
        parent::__construct();
	
        $this->load->database();

        $this->load->helper(array('url','form'));

        $this->load->library(array('session' , 'user_agent', 'General'));

        $this->load->model('Base_model');

        $this->Gen = new General();
    }

    public function load_template($layout_type='',$template,$data=array())
    {
        $data['css'] = array(
		$this->Gen->get_script_url('theme_css','bootstrap.min.css'),
		//$this->Gen->get_script_url('theme_css','bootstrap-dark.min.css'),
		$this->Gen->get_script_url('theme_css','jquery-ui.min.css'),
		$this->Gen->get_script_url('theme_css','icons.min.css'),
		$this->Gen->get_script_url('theme_css','metisMenu.min.css'),
		//$this->Gen->get_script_url('theme_css','app-dark.min.css'),
		$this->Gen->get_script_url('theme_css','app.min.css'),
		);
        $data['js'] = array(
            $this->Gen->get_script_url('theme_js','jquery.min.js'),
            $this->Gen->get_script_url('theme_js','jquery-ui.min.js'),
            $this->Gen->get_script_url('theme_js','bootstrap.bundle.min.js'),
            $this->Gen->get_script_url('theme_js','metismenu.min.js'),
            $this->Gen->get_script_url('theme_js','waves.js'),
            $this->Gen->get_script_url('theme_js','feather.min.js'),
            $this->Gen->get_script_url('theme_js','jquery.slimscroll.min.js'),
            $this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
			//$this->Gen->get_script_url('bower_components','jquery.crm_dashboard.init.js'),
            $this->Gen->get_script_url('theme_js','app.js'),
            $this->Gen->get_script_url('custom_js','notify.js'),
            
        );

        switch ($layout_type){
            case "login":
                $header = "includes/login_header";
                $footer = "includes/login_footer";
                break;
            case "no_header":
                $header = "";
                $footer = "";
                break;
            default:
                $header = "includes/header";
                $footer = "includes/footer";
                break;
        }
		// echo '<pre>';
		// print_r($template);
		// exit;
        $this->load->view($header,$data);
        $this->load->view($template,$data);
        $this->load->view($footer,$data);
    }
}