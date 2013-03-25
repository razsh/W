<?PHP
class Province {
	private $db;
	
	function Province($db) {
		$this->db = $db;
	}
	
	function getAll() {
		$st = $this->db->query("SELECT name FROM provinces");
		return($st->fetchAll());
	}
}

?>
