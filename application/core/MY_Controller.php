<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '../vendor/autoload.php';
use \Firebase\JWT\JWT;

class MY_Controller extends MX_Controller {

	private $secretkey = '123456789'; //ubah dengan kode rahasia apapun

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model('M_login','login');
	}

	// method untuk mengecek token setiap melakukan post, put, etc
    public function cektoken()
    {

        $jwt = $this->input->get_request_header('Authorization');

        try {
            $decode = JWT::decode($jwt, $this->secretkey, array('HS256'));

            if ($this->login->getUsers($decode->username)->num_rows() > 0) {
                return true;
            }

        } catch (Exception $e) {
            exit(json_encode(array('status' => '0', 'message' => 'Invalid Token')));
        }
    }

} 