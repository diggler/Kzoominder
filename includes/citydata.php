<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(LIB_PATH.DS.'database.php');

class CityData{
	
	protected static $table_name="city_data";
	protected static $db_fields = array('id','city','state','zip','type','street','street_detail','day','frequency');
	public $id;
	public $city;
	public $state;
	public $zip;
	public $type;
	public $street;
	public $street_detail;
        public $frequency;
        public $day;
	
	public static function authenticate($username="", $password="") {
    global $database;
    $username = $database->escape_value($username);
    $password = $database->escape_value($password);

    $sql  = "SELECT * FROM users ";
    $sql .= "WHERE username = '{$username}' ";
    $sql .= "AND password = '{$password}' ";
    $sql .= "LIMIT 1";
    $result_array = self::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}

	// Common Database Methods
	public static function find_all() {
		return self::find_by_sql("SELECT * FROM ".self::$table_name);
  }
  
	public static function find_by_id($id=0) {
	  $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE id={$id} LIMIT 1");
		      return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	public static function find_by_keyword($keyword){
		$result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE street LIKE '%$keyword%'");
			return $result_array;
	}
  
	public static function find_by_sql($sql="") {
	  global $database;
	  $result_set = $database->query($sql);
	  $object_array = array();
	  while ($row = $database->fetch_array($result_set)) {
	    $object_array[] = self::instantiate($row);
	  }
	  return $object_array;
	}

	private static function instantiate($record) {
		
		// Could check that $record exists and is an array
    $object = new self;
		// Simple, long-form approach:
		// $object->id 				= $record['id'];
		// $object->username 	= $record['username'];
		// $object->password 	= $record['password'];
		// $object->first_name = $record['first_name'];
		// $object->last_name 	= $record['last_name'];
		
		// More dynamic, short-form approach:
		foreach($record as $attribute=>$value){
		  if($object->has_attribute($attribute)) {
		    $object->$attribute = $value;
		  }
		}
		return $object;
	}
	
	private function has_attribute($attribute) {
	  
	  // get_object_vars returns an associative array with all attributes 
	  // (incl. private ones!) as the keys and their current values as the value
	  $object_vars = $this->attributes();
	  // We don't care about the value, we just want to know if the key exists
	  // Will return true or false
	  return array_key_exists($attribute, $object_vars);
	}

	protected function attributes(){
		//return an array of attribute keys and their values
		// This requires a list of atrbiutes in a static attribute at top of calss, but could use SQL's show fields function for alarge tables.
		$attributes = array();
		foreach(self::$db_fields as $field){
			if(property_exists($this,$field)){
				$attributes[$field] = $this->$field;
			}
		}
		return $attributes;
	}
	
	protected function sanitized_attributes(){
		global $database;
		$clean_attributes = array();
		// sanitize the values before submitting
		// Note: does nto alter the actual value of each attribute
		foreach($this->attributes() as $key => $value){
			$clean_attributes[] = $database->escape_value($value); echo $database->escape_value($value)."<br>";
		}
		return $clean_attributes;
	}
	
	function save(){
		// A new record won't have an id yet.
		return isset($this->id) ? $this->update() : $this->create();
	}
	public function create(){
		global $database;
		//Don't forget your SQL syntax and good habits:
		// - INSERT INTO table (key, key) VALUES ('value', 'value')
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitized_attributes();
		$sql = "INSERT INTO ".self::$tablename;echo $sql."<br>";
		$sql .= " VALUES ('";echo $sql."<br>";
		$sql .= join("','", array_values($attributes));echo $sql."<br>";
		$sql .= "')";echo $sql."<br>";
		if($database->query($sql)){
			$this->id = $database->insert_id();
			return true;
		}else{
			return false;
		}
	}
	public function update(){
		global $database;
		//DOn't forget your SQL syntax and good habits:
		// - UPDATE table SET key='value', key='value' WHERE condition
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		foreach($attributes as $key => $value){
			$attribute_pairs[]= "{$key}='{$value}'";
		}
		$sql = "UPDATE ".self::$tablename." SET ";
		$sql .=	join(", ", $attribute_pairs);
		$sql .=	" WHERE id=". $database->escape_value($this->id);
		$database->query($sql);
		return ($database->affected_rows()==1 ? true : false);
	}
	public function delete(){
		global $database;
		//Don't forget your SQL syntax and good habits:
		// - DELETE FROM table WHERE condition LIMIT 1
		// - escape all values to prevent SQL injection
		// - use LIMIT 1
		$sql = 	"DELETE FROM ".self::$tablename;
		$sql .=	" WHERE id=". $database->escape_value($this->id);
		$sql .=	" LIMIT 1";
		$database->query($sql);
		return ($database->affected_rows()==1 ? true : false);
	}
	
}

?>