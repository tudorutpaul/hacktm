<?php

class DB
{
	var $link;
	var $connected;
	var $result=false;
	var $host;
	var $user;
	var $pass;
	var $db_name;
	var $log;
	
	function DB($host=MYSQL_HOST,$user=MYSQL_USER,$pass=MYSQL_PASS,$db_name=MYSQL_DB)
	{
		$this->host=$host;
		$this->user=$user;
		$this->pass=$pass;
		$this->db_name=$db_name;
		$this->link=mysql_connect($this->host,$this->user, $this->pass);
		$this->connected=mysql_select_db($this->db_name,$this->link);
	}
	
	function startQuery($sql)
	{
		$this->result = mysql_query($sql);
		return is_resource($this->result);
	}
	
	function query($sql)
	{
		$ret=mysql_query($sql);
		if ($ret ===false)
		{}
		else
		{
			$ret=mysql_affected_rows();
		}
		return $ret;
	}
	
	function exists($sql)
	{
		$ret=mysql_query($sql);
		if ($ret ===false) {}
		else
		{
			$ret=mysql_num_rows($ret)>0;
		}
		return $ret;
	}
		
	function endQuery()
	{
		$ret=true;
		if (is_resource($this->result))
			$ret=mysql_free_result($this->result);
		return $ret;
	}

	function numRows()
	{
		$ret=0;
		if (is_resource($this->result))
		{
			$ret=mysql_num_rows($this->result);	
		}
		return $ret;
	}

	function nextRow()
	{
		$ret=false;
		if (is_resource($this->result))
		{
			$ret=mysql_fetch_array($this->result,MYSQL_ASSOC);	
			if ($ret===false)
				$this->endQuery();
		}
		return $ret;
	}
    
    // FUNCTII NOI
    
 	function last_id()
	{
		$ret=mysql_insert_id($this->link);
		return $ret;
	}
    
	function affectedRows()
	{
		$ret=mysql_affected_rows($this->link);
		return $ret;
	}
    
	function sanitize($string="")
	{
        $ret = mysql_real_escape_string($string,$this->link);
		return $ret;
	}
    
    function error(){
        return mysql_error($this->link);
    }
    
    function errno(){
        return mysql_errno($this->link);
    }
    
    function close(){
        return mysql_close($this->link);
    }
    
}
?>