<?php
	define('DB_USER',"root");
    define('DB_PASSWORD',"");
    define('DB_DATABASE',"u838258187_inf");
    define('DB_SERVER',"localhost");
	class DB_Connect {
 
    // constructor
    function __construct() {
 
    }
 
    // destructor
    function __destruct() {
        // $this->close();
    }
    public function connect() {
        $conn = new  mysqli(DB_SERVER,DB_USER,DB_PASSWORD,DB_DATABASE);
		mysqli_set_charset($conn, 'utf8');
        return $conn;
    }
 
    // Closing database connection
    public function close() {
        mysql_close();
    }
} 
?>