<?php
class Mod_analis extends CI_Model {  
  function click($arr) {
    $this->db->insert("history_test ",$arr);
		return $arr;
  }
}
?>

