<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
         $this->cektoken();
    }

    /* index page */
    public function index($table = '', $id = '')
    {
        if ($table == '') {
            // redirect(base_url());
        } else {
            $get_id = 'id_' . $table;
            if ($id == '') {
                // baseurl/?table=nama_table (semua data)
                $data = $this->db->get($table)->result();
            } else {
                // baseurl/?table=nama_table&id=id (satu data)
                $this->db->where($get_id, $id);
                $data = $this->db->get($table)->result();
            }
            $result = array("data" => $data, 'status' => 'success');
            echo json_encode($result);
        }
    }

}

/* End of file Api.php */
/* Location: ./application/controllers/Api.php */
