<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Main_models', 'main');
	}


    public function index(){
    	$data['title'] = 'Business Center';

        $this->load->view('main', $data);
    }

    public function business_center_main_rest(){
    	return $this->output->set_content_type('application/json')->set_output(json_encode($this->main->load_barang()->result()));
    }
    public function business_center_main_hot_rest(){
        return $this->output->set_content_type('application/json')->set_output(json_encode($this->main->barang_baru()->result()));
    }

    public function business_center_main_notes_rest(){
        return $this->output->set_content_type('application/json')->set_output(json_encode($this->main->load_notes()->result()));
    }

    public function business_center_main_log_rest(){
        return $this->output->set_content_type('application/json')->set_output(json_encode($this->main->load_logs()->result()));
    }

    public function business_center_main_first_log_rest(){
        return $this->output->set_content_type('application/json')->set_output(json_encode($this->main->first_logs()->result()));
    }

    public function business_center_get_success_bill(){
        return $this->output->set_content_type('application/json')->set_output(json_encode($this->main->sukses()->result()));
    }

    public function business_center_get_detail_bill(){
        $token = $this->input->post('token');
        $get = $this->main->detail($token)->result();
        echo json_encode($get);
    }

    public function business_center_main_get_token(){
        $id = $this->input->post('id_user');
        $get = $this->main->token($id)->result();
        echo json_encode($get);
    }
}