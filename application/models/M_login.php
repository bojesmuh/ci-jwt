<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_login extends CI_Model {

	 public function getUsers($username){
            $this->db->select('*');
            $this->db->from('users');
            $this->db->where('email',$username);
            $query = $this->db->get();
            return $query;
          }

}

/* End of file M_login.php */
/* Location: ./application/models/M_login.php */