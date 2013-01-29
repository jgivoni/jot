<?php

/**
 * This is the old class that should be surpassed by a more modern pattern
 */
class DatabaseAdapter
// Creates and maintains a connection to a single database (mysql)
{
	private $conn;
	private $query_time = 0;
	private $queries = 0;
	var $log = array();
	private $host, $name, $user, $pwd;
	var $auto_create_database = false;
	var $debug_enabled = false;
	var $records_matched = 0;
	
	function __construct($host, $name, $user, $pwd)
	{
		unset($this->conn);
		$this->host = $host;
		$this->name = $name;
		$this->user = $user;
		$this->pwd = $pwd;
	}
		
	function enable_debugging()
	{
		$this->debug_enabled = true;
	}
	function disable_debugging()
	{
		$this->debug_enabled = false;
	}
	
	function _is_connected()
	{
		return isset($this->conn) ? true : false;
	}
	
	function connect($auto_create = false)
	{
		if ($this->_is_connected())
			return true;

		$this->conn = @mysql_connect($this->host, $this->user, $this->pwd);
		if ($this->conn === false)
		{
			unset($this->conn);
			throw new VesselException("Couldn't open database connection", null, null,
				array("host" => $this->host, 
				"mysql_error" => mysql_error()));
		}
		
		mysql_query("SET NAMES 'utf8'", $this->conn);
		mysql_query("SET SQL_BIG_SELECTS=1");
		
		$this->auto_create_database = $auto_create;
		if ($this->auto_create_database)
		{
			mysql_query("CREATE DATABASE IF NOT EXISTS " . $this->name);
		}

		$result = mysql_select_db($this->name, $this->conn);
		if ($result === false)
		{
			throw new VesselException("Couldn't select database", null, null,
				array("database_name" => $this->name, 
				"mysql_error" => mysql_error($this->conn)));
		}
		
	}
	
	function close()
	{
		if ($this->_is_connected())
			mysql_close($this->conn);
	}
	
	function exec_query($statement) 
	// Executes an SQL statement
	// Returns either an array with the result of a SELECT statement, 
	// or the ID returned from an INSERT statement
	{
		$this->connect();
		
		$statement = trim($statement);

		if ($this->debug_enabled)
		{
			$start_time = microtime(true);
			$logidx = array_push($this->log, array()) - 1;
			$this->log[$logidx] = array();
			$this->log[$logidx]["sql"] = $statement;
			if (preg_match("/^SELECT\b/ui", $statement))
			{
				$explain = mysql_query("EXPLAIN $statement", $this->conn);
				if ($explain !== false)
				{
					while ($row = mysql_fetch_array($explain, MYSQL_ASSOC))
					{
						$this->log[$logidx]["explain"][] = $row;
					}
				}
			}
		}
			

		$result = mysql_query($statement, $this->conn);

		if ($result === false)
		{
			throw new VesselException("Couldn't execute SQL statement", null, null,
				array("SQL" => $statement,
					"mysql_error" => mysql_error($this->conn)));
		}
		
		if ($result === true)
		{
			if (preg_match("/^INSERT\b/ui", $statement))
			{
				$id = mysql_insert_id();
				if ($this->debug_enabled)
				{
					$this->log[$logidx]["id"] = $id;
				}
				return $id;
			}
		}
		else
		{
			$rows = array();
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				array_push($rows, $row);
			}
				
			if (preg_match("/^SELECT\s+SQL_CALC_FOUND_ROWS\b/ui", $statement))
			{
				if (count($rows) == 0)
				{
					$rows[] = array();
				}
				$this->rows_matched = $this->fetch_rows_matched();
			}
			if ($this->debug_enabled)
			{
				$this->log[$logidx]["result"] = $rows;
			}
		}
		
		if ($this->debug_enabled)
		{
			$this->log[$logidx]["time"] = round((microtime(true) - $start_time), 3);
		}
		
		return $result === true ? true : $rows;
	}
	
	private function fetch_rows_matched()
	{
		$result = mysql_query("SELECT FOUND_ROWS() AS 'rows_matched'");
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		$rows_matched = $row["rows_matched"];
		return $rows_matched;
	}
	
	function get_rows_matched()
	{
		return $this->rows_matched;
	}
	
	function escape($str)
	{
		$this->connect();
		
		return mysql_real_escape_string($str);
	}
}

?>