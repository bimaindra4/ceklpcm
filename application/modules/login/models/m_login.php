<?php if (!defined('BASEPATH')) exit('Maaf, akses secara langsung tidak diperkenankan.');
class M_login extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function getUser($u,$p) {
		$sql = $this->db->query("SELECT * FROM user WHERE username='$u' AND password='$p'");
		return $sql;
	}
}
?>