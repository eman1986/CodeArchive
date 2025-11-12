<?php
/**
 * MySQL.class.php
 * @author Ed Lomonaco
 * @copyright  (c) 2006-2011
 * @license https://opensource.org/license/mit
 * @version 9/14/2011
*/


class MySQLWrapper{

    /**
	 * SQL command to execute.
	 * @var string
	*/
	public $SQL;
	
	/**
	 * SQL connection string.
	 * @var string
	*/
	private $connStr;

	/**
	 * Attempt to initialize Database Connection.
	 * @param string $host MySQL Host Addrss.
	 * @param string $dbUser MySQL Username.
	 * @param string $dbPwd MySQL Password.
	 * @param string $dbNme MySQL Database.
	 * @access Public
	 * @version 9/14/2011
	*/
	public function __construct($host, $dbUser, $dbPwd, $dbNme){
		try{
			$this->connStr = mysql_connect($host, $dbUser, $dbPwd) or die("Failed to connect to MySQL host.<br />". mysql_error() ."<br /><br /><strong>Line:</strong> ". __LINE__ ."<br /><strong>File:</strong> ". __FILE__);
			mysql_select_db($dbNme, $this->connStr) or die("Failed to select mysql DB.<br />". mysql_error() ."<br /><br /><strong>Line:</strong> ". __LINE__ ."<br /><strong>File:</strong> ". __FILE__);

			#tell connection to use UTF-8 encoding.
			mysql_set_charset('utf8', $this->connStr);
    	}catch(Exception $e){
	        $error = new notifySys($e, true, true, __FILE__, __LINE__);
			$error->genericError();
    	}
	}

    /**
	 * Attempt to Disconnect Database Connection.
	 * @access Public
	 * @version 9/14/2011
	*/
	public function __destruct(){
		mysql_close($this->connStr);
	}

	/**
	 * Performs a basic MySQL query.
	 * @access Public
	 * @version 9/14/2011
	*/
	public function query(){
		try{
		    $query = mysql_query($this->SQL, $this->connStr) or die("Failed to query the database<br />". mysql_error() ."<br /><br /><strong>Line:</strong> ". __LINE__ ."<br /><strong>File:</strong> ". __FILE__."<br /><br />SQL Command:</strong><br /><textarea name=\"sqlquery\" rows=\"5\" cols=\"150\" class=\"text\" readonly=readonly>".$this->SQL."</textarea><br /><br />");

	    	return($query);
    	}catch(Exception $e){
	        $error = new notifySys($e, true, true, __FILE__, __LINE__);
			$error->genericError();
    	}
	}

	/**
	 * Obtain a number of rows affected by the defined SQL Query.
	 * @access Public
	 * @version 9/14/2011
	*/
	public function affectedRows(){
		try{
		    $affectedRows = mysql_num_rows($this->query());

			return($affectedRows);
    	}catch(Exception $e){
	        $error = new notifySys($e, true, true, __FILE__, __LINE__);
			$error->genericError();
    	}
	}

	/**
	 * Fetch data based on SQL Query.
	 * @access Public
	 * @version 9/14/2011
	*/
	public function fetchResults(){
		try{
	    	$dbResult = mysql_fetch_assoc($this->query());

			return($dbResult);
    	}catch(Exception $e){
	        $error = new notifySys($e, true, true, __FILE__, __LINE__);
			$error->genericError();
    	}
	}

	/**
	 * Obtains current connection's MySQL Version.
	 * @access Public
	 * @version 9/14/2011
	*/
	public function dbVersion(){
		try{
			$mysqlVersion = mysql_get_server_info($this->connStr);
			$mysqlVersionInfo = substr($mysqlVersion, 0, strpos($mysqlVersion, "-"));

			return($mysqlVersionInfo);
    	}catch(Exception $e){
	        $error = new notifySys($e, true, true, __FILE__, __LINE__);
			$error->genericError();
    	}
	}

	/**
	 * Filters values to be SQL-friendly.
	 * @access Public
	 * @param string $str the data you want to use in a SQL Query.
	 * @return string $string the filtered data ready for SQL use.
	 * @version 9/14/2011
	*/
	public function filterMySQL($str){

		$string = mysql_real_escape_string(trim($str), $this->connStr);

		return($string);
	}
}
?>
