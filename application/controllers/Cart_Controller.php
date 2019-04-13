<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart_Controller extends CI_Controller{

	private $_id_user = array(
		array(
			'field'=>'id_user',
			'label'=>'ID Pengguna',
			'rules'=>'required|alpha_numeric',
			'errors'=>array(
				'required' 				=> 'ID Pengguna Wajib',
				'alpha_numeric'			=> 'Tidak boleh mengandung karakter khusus (termasuk space)',
			)
		)
	);

	public $_result = array(
		'error' => '',
		'data'=>array(),
		'message' => array(
			'id_user' => ''
		)
	);

	public function __construct(){
		parent::__construct();
		$this->load->model('Cart_models');
	}

	public function index(){
		$data = array(
			'id' => $this->input->post('code'),
			'qty' => $this->input->post('qty'),
			'price' => $this->input->post('sprice'),
			'name' => $this->input->post('name'),
		);
		$this->cart->insert($data);
		echo $this->business_center_main_show_cart();
	}
	public function business_center_main_load_cart(){
		echo $this->business_center_main_show_cart();	
	}
	public function business_center_main_show_cart(){
		// $data = array(
		// 	'cart' => $this->cart->contents(),
		// 	'total' => $this->cart->total()
		// );
		// return $this->output->set_content_type('application/json')->set_output(json_encode($data));
		$output = '';
		$no = 0;
        foreach ($this->cart->contents() as $items) {
        	$no++;
            $output .='
	  			<tr>
	  				<th scope="row">'.$no++.'</th>
	  				<td>'.$items['id'].'</td>
	  				<td>'.$items['name'].'</td>
	  				<td> Rp. '.number_format($items['price']).'</td>
	  				<td>'.$items['qty'].'</td>
	  				<td> Rp. '.number_format($items['subtotal']).'</td>
	  				<td><button type="button" id="'.$items['rowid'].'" class="remove_cart btn btn-danger btn-sm  waves-effect waves-light">
	  					<span class="fa fa-trash-alt text-white"></span>
	  				</button></td>
	  			</tr>
            ';
        }
        $output .= '
            <tr>
                <th colspan="5">Total</th>
                <th colspan="2">'. 'Rp. '.number_format($this->cart->total()).'</th>
            </tr>
	        ';
        return $output;
	}
	public function business_center_main_delete_cart(){
        $data = array(
            'rowid' => $this->input->post('data'), 
            'qty' => 0, 
        );
        // echo json_encode(($data));
        $this->cart->update($data);
        echo $this->business_center_main_show_cart();
	}
	public function business_center_main_bill_cart(){
		$this->form_validation->set_rules($this->_id_user);
		if($this->form_validation->run() == FALSE){
			$result['error'] = TRUE;
			$result['success'] = FALSE;
			$result['message'] = array(
				'id_user'=>form_error('id_user')
			);
			$result['datas'] = '';
		}else{
			$id = $this->input->post('id_user');
			$now = date('Y-m-d', time());
			$where = array('id_user' => $id, 'user' => $this->session->userdata('nama'));
			$check = $this->Cart_models->check_id("user", $where)->num_rows(); //cek id
			if($check > 0){
				$result['error'] = FALSE;
				$result['success'] = TRUE;
				$result['message'] = array(
					'id_user'=> ''
				);
					$sql = array();
					$stok = array();
					foreach ($this->cart->contents() as $values) {
						$sql[] = '("'.uniqid(rand()).date('mdYhis', time()).'", "'.$id.'" , "'.$values['id'].'" ,"'.crypt($id, date('YmdHis', time())).'", "'.$values['name'].'", "'.$this->db->escape($values['qty']).'", "'.$this->db->escape($values['price']).'", "'.$this->db->escape($values['subtotal']).'", "'.$this->db->escape($this->cart->total()).'", "'.$now.'" ,"queue")';
						$stok[] = '("'.$this->db->escape($values['qty']).'")';
					}
					if($this->Cart_models->insert_bill($sql)){
						$result['message'] = array(
							'id_user'=> 'Berhasil'
						);
					}
			}else{
				$result['error'] = TRUE;
				$result['success'] = FALSE;
				$result['message'] = array(
					'id_user'=> 'ID Tidak Cocok!'
				);
				$result['datas'] = '';
			}
		}
		echo json_encode($result);
	}
	public function business_center_main_get_bill(){
    	return $this->output->set_content_type('application/json')->set_output(json_encode($this->Cart_models->get_bill()->result()));
    }

}?>