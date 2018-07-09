<?php
class Database {
    private $conn;
	private static $_instance; //The single instance
	private $host = "localhost";
	private $user = "root";
	private $password = "";
	private $database = "movies_site";
    public static function getInstance() {
		if(!self::$_instance) { // If no instance then make one
			self::$_instance = new self();
		}
		return self::$_instance;
	}
    
	private function __construct() {
		$conn = $this->connectDB();
		if(!empty($conn)) {
			$this->conn = $conn;
		}
	}

	function connectDB() {
		$conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
        if(!$conn) {
          die('Failed to connect to server: ' . mysqli_error($this->conn));
        }
        return $conn;
	}

	public function select($query) {
		$result = mysqli_query($this->conn,$query);
		while( $row = mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}
		if(!empty($resultset)){
			return $resultset;
		}
		else return mysqli_error($this->conn);

	}
    public function fetch($query) {
		$result = mysqli_query($this->conn,$query);
		return $result;

	}

	 public function execute($query) {
		$result = mysqli_query($this->conn, $query);
		if($result) return true;
		else return false;
	}

	public function insert_and_get_pk($query) {
		$result = mysqli_query($this->conn, $query);
		if($result) return mysqli_insert_id($this->conn);
		else return mysqli_error($this->conn);
	}
}

?>
