<?php if (!defined('BASEPATH')) exit('Maaf, akses secara langsung tidak diperkenankan.');
class M_user extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    
    function getIDRekammed($val) {
        $this->db->where("username", $val);
        $this->db->where("status", 1);
        $q = $this->db->get("user")->row();

        return $q->id_user;
    }

    function insertUser($data) {
        $q = $this->db->insert("user", $data);
        if($q) {
            return true;
        } else {
            return false;
        }
    }

    function updateUser($data,$id) {
        $q = $this->db->update("user", $data, array("id_user" => $id));
        if($q) {
            return true;
        } else {
            return false;
        }
    }
}
?>