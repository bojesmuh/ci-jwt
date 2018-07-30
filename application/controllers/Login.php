<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '../vendor/autoload.php';
use \Firebase\JWT\JWT;

class Login extends MY_Controller
{

    private $secretkey = '123456789'; //ubah dengan kode rahasia apapun

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('M_login','login');
    }

    // method untuk melihat token pada user
    public function generate_post()
    {

        
        $date      = new DateTime();
        $username  = $this->input->post('username', true); //ini adalah kolom username pada database yang saya berinama username.
        $pass      = $this->input->post('password', true); //ini adalah kolom password pada database yang saya berinama password.
        $dataadmin = $this->login->getUsers($username)->row();


        /* echo json_encode(password_hash($dataadmin->password, PASSWORD_DEFAULT));exit;*/

        if ($dataadmin) {


            if (password_verify($pass, $dataadmin->password)) {
                $payload['id']       = $dataadmin->id;
                $payload['username'] = $dataadmin->username;
                $payload['iat']      = $date->getTimestamp(); //waktu di buat
                $payload['exp']      = $date->getTimestamp() + 3600; //satu jam
                $output['token']     = JWT::encode($payload, $this->secretkey);
               
                echo json_encode($output);
                // return $this->response($output, REST_Controller::HTTP_OK);
            } else {
                $this->viewtokenfail($username);
            }
        } else {
            $this->viewtokenfail($username);
        }
    }

    // method untuk jika generate token diatas salah
    public function viewtokenfail($username)
    {
        $result = array(
            'status'   => '0',
            'username' => $username,
            'message'  => 'Invalid Username Or Password',
        );

        echo json_encode($result);
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

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */
