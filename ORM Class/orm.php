<?php
/**
 * orm.php
 * Date Modified: 8/17/2011
*/

/**
 * ORM Class is a wrapper for the Redbean library <http://redbeanphp.com>.
 * This streamlines the process of using that library and removes redundant
 * code usage from our solution, resulting in better managed code.
*/
class ORM {

    /**
    * Connect to the database
    * @access public
    * @param type str the database we're connecting to.
    * @param file str the sqlite database file to load up.
    * @param host str the database server to connect to.
    * @param dbnme str the name of the database.
    * @param usr str the username to this database.
    * @param pwd str the password to the database.
    * @param debug bool determines if we want to see sql on error.
    */
    public function __Construct($type, $file="",$host="localhost", $dbnme="", $usr="root", $pwd="", $debug=false) {

        //see what type of database we're loading.
        switch($type) {
        case "sqlite":
            //see if SQLite is installed.
            if (!function_exists('sqlite_open')) {
				exit('SQLite is not installed.');
            } else {
	            //see if they have SQLite 3 or newer.
	            if (sqlite_libversion() < 3) {
	                exit('Your version of SQLite is too old.');
	            } else {
	                R::setup('sqlite:'.$file, $usr, $pwd);
	            }
            }
        break;
        case "pgsql":
            //see if PostgreSQL is installed.
			if (!function_exists('pg_connect')) {
				exit('PostgreSQL is not installed.');
            } else {
	            //basic connection for testing.
	            $dbConn = pg_connect('host='.$host.';dbname='.$dbnme) or die("Could not connect");
	            $pgsqlVer = pg_version($dbConn);

	            //see if they have PostgreSQL 8 or newer.
	            if ($pgsqlVer['client'] < 8.0){
	                exit('Your version of PostgreSQL is too old.');
	            } else {
	                R::setup('pgsql:host='.$host.';dbname='.$dbnme, $usr, $pwd);
	            }
            }
        break;
        case "mysql":
        default:
            //see if MySQL is installed.
			if (!function_exists('mysql_connect')) {
				exit('MySQL is not installed.');
            } else {
	            //basic connection for testing.
	            $dbConn = mysql_connect($host, $usr, $pwd) or die("Failed to connect to MySQL host.");
	            $mysqlVersion = mysql_get_server_info($dbConn);
				$mysqlVersionInfo = substr($mysqlVersion, 0, strpos($mysqlVersion, "-"));

	            //see if they have MySQL 5 or newer.
	            if($mysqlVersionInfo < 5.0) {
	                exit('Your version of MySQL is too old.');
	            } else {
	                R::setup('mysql:host='.$host.';dbname='.$dbnme, $usr, $pwd);
	            }
            }
        break;
        }
        
        #setup debug mode (set to true only during development).
        R::debug($debug);
    }

    /**
    * Add a new connection.
    * @access public
    * @param dbConn str connection name.
    * @param connStr str connection string.
    * @param usr str connection username.
    * @param pwd str connection password.
    */
	public function AddConnection($dbConn, $connStr, $usr, $pwd) {
		R::addDatabase($dbConn, $connStr, $usr, $pwd);
	}
	
    /**
    * Change the database connection.
    * @access public
    * @param dbConn str connection name.
    */
	public function ChangeConnection($dbConn) {
	    R::selectDatabase($dbConn);
	}

    /**
    * Inserts/Update a record into the Database.
    * @access public
    * @param obj object the object that has all of our data.
    */
    public function Save($obj) {
	    $id = R::store($obj);

	    return $id;
    }

    /**
    * Create new record entity.
    * @access public
    * @param tblName str the table to draw from.
    */
    public function Create($tblName) {
        return R::dispense($tblName);
    }
    
    /**
    * Loads a record from the Database.
    * @access public
    * @param tblName str the table to draw from.
    * @param id array the ID to look up.
    */
    public function Load($tblName, $id) {
        return R::load($tblName, $id);
    }
    
    /**
    * Deletes a record from the Database.
    * @access public
    * @param obj object the object that has all of our data.
    */
    public function Delete($obj){
        R::trash($obj);
    }

    /**
    * Delete ENTIRE Table.
    * @access public
    * @param tblName str the table to draw from.
    */
    public function ClearAll($tblName) {
	    R::wipe($tblName);
    }
    
    /**
    * Get Search Result for multiple records.
    * @access public
    * @param tblName str the table to draw from.
    * @param filter str the column(s) to search from.
    * @param filterVal str the value of the filters.
    */
    public function Search($tblName, $filter, $filterVal) {
    	return R::find($tblName, $filter, $filterVal);
    }
    
    /**
    * Get Search Result for one record.
    * @access public
    * @param tblName str the table to draw from.
    * @param filter str the column(s) to search from.
    * @param filterVal str the value of the filters.
    */
    public function Get($tblName, $filter, $filterVal) {
        return R::findOne($tblName, $filter, $filterVal);
    }
    
    /**
    * Get row count of defined object.
    * @access public
    * @param tblName str the table to draw from.
    */
    public function NumResults($tblName) {
    	return R::count($tblName);
    }

    /**
    * Execute SQL Command.
    * @access public
    * @param sql str the SQL command.
    */
    public function query($sql) {
		return R::exec($sql);
    }

}
?>
