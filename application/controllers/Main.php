<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Main extends CI_Controller{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Main_models');
	}


    public function index(){
    	$data['title'] = 'Business Center';

        $this->load->view('main', $data);
    }

    public function business_center_main_rest(){
    	return $this->output->set_content_type('application/json')->set_output(json_encode($this->Main_models->load_barang()->result()));
    }

    public function business_center_main_notes_rest(){
        return $this->output->set_content_type('application/json')->set_output(json_encode($this->Main_models->load_notes()->result()));
    }

    public function business_center_main_log_rest(){
        return $this->output->set_content_type('application/json')->set_output(json_encode($this->Main_models->load_logs()->result()));
    }

    public function business_center_main_first_log_rest(){
        return $this->output->set_content_type('application/json')->set_output(json_encode($this->Main_models->first_logs()->result()));
    }
}