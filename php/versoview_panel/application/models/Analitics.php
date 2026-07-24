<?php
class Analitics extends CI_Model {  
	function click($arr) {
		$table = $this->historyTable();
		$data = $this->filterHistoryFields($arr, $table);
		$this->saveHistoryRecord($table, $data);
		return $data;
	}

	function clickBatch($rows) {
		$affected = 0;
		$table = $this->historyTable();

		foreach ($rows as $row) {
			$data = $this->filterHistoryFields($row, $table);

			if (count($data) > 0) {
				$affected += $this->saveHistoryRecord($table, $data);
			}
		}

		return $affected;
	}

	private function historyTable() {
		return 'history';
	}

	private function saveHistoryRecord($table, $data) {
		if (count($data) === 0) {
			return 0;
		}

		if ($this->hasHistoryField($table, 'reading_id') && !empty($data['reading_id'])) {
			$exists = $this->db
				->select('reading_id')
				->from($table)
				->where('reading_id', $data['reading_id'])
				->limit(1)
				->get()
				->num_rows() > 0;

			if ($exists) {
				$this->db->where('reading_id', $data['reading_id'])->update($table, $data);
				return max(1, $this->db->affected_rows());
			}
		}

		$this->db->insert($table, $data);
		return $this->db->affected_rows();
	}

	private function hasHistoryField($table, $field) {
		static $tableFields = array();

		if (!isset($tableFields[$table])) {
			$tableFields[$table] = array_flip($this->db->list_fields($table));
		}

		return isset($tableFields[$table][$field]);
	}

	private function filterHistoryFields($data, $table) {
		static $tableFields = array();

		if (!isset($tableFields[$table])) {
			$tableFields[$table] = array_flip($this->db->list_fields($table));
		}

		foreach ($data as $key => $value) {
			$data[$key] = $this->normalizeScalarValue($value);
		}

		if (isset($data['uid']) && strlen($data['uid']) > 24) {
			$data['uid'] = substr($data['uid'], 0, 24);
		}

		return array_intersect_key($data, $tableFields[$table]);
	}

	private function normalizeScalarValue($value) {
		if (is_array($value)) {
			foreach (array('country', 'regional', 'city', 'continent') as $key) {
				if (isset($value[$key]) && !is_array($value[$key]) && !is_object($value[$key])) {
					return $value[$key];
				}
			}

			return json_encode($value);
		}

		if (is_object($value)) {
			return json_encode($value);
		}

		if (is_bool($value)) {
			return $value ? 1 : 0;
		}

		return $value;
	}
	function cekip($nzr) {
		$this->updDataForm("ip","new","ip",$nzr["ip"],$nzr);
	}
  
	public function get_content($tbl, $kolom, $id)
	{
			if (is_array($kolom)) {
					$has =  $this->db->get_where($tbl, $kolom);
			} else {
					$has =  $this->db->get_where($tbl, array($kolom => $id));
			}
			// $ttl = count($has->result());
			return each_query($has);
	}
	function updDataForm($tbl, $tipe, $kolom, $uid,  $data_array)
	{
		if (is_array($kolom)) {
			$has =  $this->db->get_where($tbl, $kolom);
		} else {
			$has =  $this->db->get_where($tbl, array($kolom => $uid));
		}
		$ttl = count($has->result());
		if ($tipe == "Hapus") {
			$result = $this->hapusin_data($tbl, $kolom, $uid);
		} elseif ($tipe == "new") {
			if ($ttl == 0) {
				$result = $this->masukin_data($data_array, $tbl, "");
			}else{
				$result = "";
			}
		} else {
			if ($ttl == 0) {
				$result = $this->masukin_data($data_array, $tbl, "");
			} else {
				if (is_array($kolom)) {
					$where  = $kolom;
				} else {
					$where  = array($kolom => $uid);
				}
				$result = $this->editin_data($data_array, $tbl, "", $where);
			}
		}
		return $result;
	}

	function masukin_cek($array, $table, $tipe)
	{
			$cek = $this->db->get_where($table, $array);
			if (count($cek->result()) == 0) {
					$this->masukin_data($array, $table, $tipe);
			} else {
					return false;
			}
	}

	function masukin_data($array, $table, $tipe)
	{
		if ($tipe == "batch") {
			$this->db->insert_batch($table, $array);
		} else {
			$this->db->insert($table, $array);
		}
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
		return FALSE;
	}

	function editin_data($array, $table, $tipe, $where)
	{
		if ($tipe == "batch") {
			$y = $this->db->insert_batch($table, $array);
		} else {
			$this->db->where($where);
			$y = $this->db->update($table, $array);
		}
		return $y;
	}

	function hapusin_data($table, $kolom, $id)
	{
		$this->db->where($kolom, $id);
		$y = $this->db->delete($table);
		return $y;
	}
}
?>

