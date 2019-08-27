<?php if (!defined('BASEPATH')) exit('Maaf, akses secara langsung tidak diperkenankan.');
class M_klpcm extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    
    function getNoRM($val) {
        $this->db->select("rm.*, d.nama_dokter AS dpjp, d1.nama_dokter AS dokter1, d2.nama_dokter AS dokter2, r.nama_ruang");
        $this->db->join("dokter d", "rm.instalasi_dpjp = d.id_dokter");
        $this->db->join("dokter d1", "rm.dokter_1 = d1.id_dokter", "left");
        $this->db->join("dokter d2", "rm.dokter_2 = d2.id_dokter", "left");
        $this->db->join("ruang r", "rm.id_ruang = r.id_ruang");
        $this->db->where("rm.no_rm", $val);
        $db = $this->db->get("rekam_medis rm");
        return $db->row();
    }

    function getDokter() {
        $this->db->select("id_dokter, nama_dokter");
        $db = $this->db->get("dokter");
        return $db;
    }

    function getForm() {
        $db = $this->db->get("form_rawat_inap");
        return $db;
    }

    function getRuang() {
        $db = $this->db->get("ruang");
        return $db;
    }

    function getFormTL($id,$ket) {
        $this->db->where("no_rm", $id);
        $this->db->where("keterangan", $ket);
        $q = $this->db->get('tl_rawat_inap');

        $out = "";
        foreach($q->result() as $row) {
            $out .= "'".$row->id_rawat_inap."', ";
        }

        return rtrim($out, ", ");
    }

    function updateFormRM($data,$id) {
        $db = $this->db->update("rekam_medis", $data, array("no_rm" => $id));
        ($db) ? $out=true : $out=false;
        return $out;
    }

    function insertFormTL($id,$var_ket,$ket) {
        // Hapus dulu isinya
        $this->db->where("no_rm", $id);
        $this->db->where("keterangan", $ket);
        $q = $this->db->delete('tl_rawat_inap');

        // Baru diisi lagi
        for ($i=0; $i<count($var_ket); $i++) { 
            $data = [
                "id_rawat_inap" => $var_ket[$i],
                "no_rm" => $id,
                "keterangan" => $ket
            ];
            
            $this->db->insert("tl_rawat_inap", $data);
        }
    }

    function deleteFormTL($id,$ket) {
        $this->db->where("no_rm", $id);
        $this->db->where("keterangan", $ket);
        $q = $this->db->delete('tl_rawat_inap');
        ($q) ? $out=true : $out=false;
        return $out;
    }
}
?>