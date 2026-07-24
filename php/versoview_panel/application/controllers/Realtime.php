<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Realtime extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		// $this->load->model('Mod_analis');
	}
	public function index($value = "")
	{
		$time = "10";
		if(isset($_GET["loop"])){
			if(is_numeric($_GET["loop"]) && $_GET["loop"]>=3){
				$time = $_GET["loop"];
			}
		}
		echo '<META http-equiv="refresh" content="' . $time . ';URL=">';
		echo '<style>
					table, th, td {
						border: 1px solid #ddd;
						border-collapse: collapse;
					}
					body td{font-size:12px !important}
				</style>';
		echo '<script>
				var timeleft =' . $time . ';
					var downloadTimer = setInterval(function(){
					if(timeleft <= 0){
						clearInterval(downloadTimer);
					}
					document.getElementById("timer").innerHTML  = timeleft -1 ;
					timeleft -= 1;
					}, 1000);
		</script>';
		echo '<h2>realtime data every ' . $time . ' second last run in ' . date("d-m-Y H:i:s") . ' => <span id="timer">' . $time . '</span></h2>';

		if (isset($_GET['table'])) {
			$tbl = $_GET['table'];
			$sintak1 = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'versoview' AND TABLE_NAME = '$tbl';";
			$sintak2 = "SELECT * FROM $tbl order by 1 desc limit 100";
			$hdr     = $this->db->query($sintak1)->result();
			$dtl     = $this->db->query($sintak2)->result();
			echo "<table border='1'>";
			foreach ($hdr as $key => $data_hdr) {
				echo "<th>" . $data_hdr->COLUMN_NAME . "</th>";
			}
			foreach ($dtl as $key => $data_dtl) {
				echo "<tr>";
				foreach ($data_dtl as $key => $data_dtl_val) {
					echo "<td>" . $data_dtl_val . "</td>";
				}
				echo "</tr>";
			}
			echo "</table>";
			// dbg($query);
		};
	}
}
