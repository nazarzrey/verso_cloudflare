<?php
  class Mod_data extends CI_Model {
 
      function getID($id) {
        $this->db->where("id",$ID);
        return $this->db->get("tuser");
      }
      function getTahun() {
        $this->db->order_by("tahun","desc");
        return $this->db->get("ttahun");
      }
      function getStatus() {
        $this->db->order_by("id","asc");
        return $this->db->get("tjabatan");
      }
      function getMataPelajaran() {
        $this->db->order_by("id","desc");
        return $this->db->get("tmatpel");
      }
      function getExtrakulikuler() {
        $this->db->order_by("id","desc");
        return $this->db->get("textra");
      }
       function getWalikelas() {
        $query = $this->db->query('select * from tkelas a,tuser b where a.wali_kelas=b.username order by kelas asc');
        return $query;
      }
      function getSekolah() {
        $this->db->order_by("id","desc");
        return $this->db->get("tsekolah");
      }
      function getPrestasi() {
        $this->db->order_by("id","desc");
        return $this->db->get("tprestasi");
      }
      function getBerita() {
        $query = $this->db->query('select * from tuser a, tberita b where a.username=b.penulis and b.level="0" order by b.tgl_upload desc  limit 0,3');
        return $query;
      }
      function getBeritaUtama() {
        $query = $this->db->query('select * from tuser a, tberita b where a.username=b.penulis and b.level="1" order by b.tgl_upload desc');
        return $query;
      }
      function getListBerita() {
        $query = $this->db->query('select * from tuser a, tberita b where a.username=b.penulis order by b.tgl_upload desc');
        return $query;
      }
      function getDetailBerita($id) {
        $query = $this->db->query('select * from tuser a, tberita b where a.username=b.penulis and b.id="'.$id.'" order by b.tgl_upload desc  limit 0,3');
        return $query;
      }
      function getListArtikel() {
        $this->db->order_by("tgl_upload","desc");
        return $this->db->get("tartikel");
      }
      function getAgenda() {
        $this->db->order_by("tgl_agenda","desc");
        return $this->db->get("tagenda");
      }
      function getSilabus() {
        $this->db->order_by("id","asc");
        return $this->db->get("tsilabus");
      }
      function getDetailAgenda($id) {
        $this->db->where('id',$id);
        $this->db->order_by("tgl_agenda","desc");
        return $this->db->get("tagenda");
      }
      function getDetailArtikel($id) {
        $this->db->where("id",$id);
        $this->db->order_by("tgl_upload","desc");
        return $this->db->get("tartikel");
      }
      function getTimeline() {
        $this->db->order_by("tgl_upload","desc");
        return $this->db->get("ttimeline");
      }
      function getUser() {
        $this->db->order_by("id","desc");
        return $this->db->get("tuser");
      }
       function getUserBerita() {
        $query = $this->db->query('select * from tuser a, tberita b where a.username=b.penulis');
        return $query;
      }
       function getJmlReadBerita($id) {
        $this->db->where('id',$id);
        $this->db->select('SUM(hit) as total');
        $this->db->from('tlog_read_berita');
        return $this->db->get()->row()->total;
      }
  }
?>
