<?php
/*
数据库
CREATE TABLE `online` (
  `hash` varchar(32) collate utf8_unicode_ci NOT NULL,
  `ip` varchar(20) character set utf8 NOT NULL default '',
  `ua` varchar(255) character set utf8 NOT NULL default '',
  `refer` varchar(255) collate utf8_unicode_ci default NULL,
  `lastmove` int(10) NOT NULL,
  `firsttime` int(10) default NULL,
  `uri` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`hash`),
  UNIQUE KEY `hash` (`hash`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

 */
/**
 * 判定多久未响应的用户为已经离开的用户
 * @var int
 */

define('ONLINE_DURATION', 600);

/**
 * 
 * 本类用来对在线用户进行统计
 * 
 * @package online
 * @author freefcw
 * @link http://www.missway.cn
 * 
 */
class online{
	/**
	 * database connect
	 * @var databse link
	 */
	protected $db;
	/**
	 * current user ip
	 * @var string
	 */
	protected $ip;
	/**
	 * current user agent
	 * @var string
	 */
	protected $ua;
	/**
	 * cureent user visit web uri
	 * @var string
	 */
	protected $uri;
	/**
	 * session id
	 * @var string
	 */
	protected $hash;
	/**
	 * cureent user refer uri
	 * @var string
	 */
	protected $refer;
	//can add function:
	//example click number count
	protected $click;

	/**
	 * construct fuction,init database link
	 * @return void
	 */
	function __construct()
	{
		global $mysqli;
		$this->ip = mysqli_real_escape_string($mysqli,$_SERVER['REMOTE_ADDR']);
      
      
         if( !empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ){

                    $REMOTE_ADDR = $_SERVER['HTTP_X_FORWARDED_FOR'];
                    
                    $tmp_ip=explode(',',$REMOTE_ADDR);

                    $this->ip =mysqli_real_escape_string($mysqli,htmlentities($tmp_ip[0],ENT_QUOTES,"UTF-8"));

        }

		$this->ua = mysqli_real_escape_string($mysqli,htmlentities($_SERVER['HTTP_USER_AGENT'],ENT_QUOTES,"UTF-8"));
		$this->uri = mysqli_real_escape_string($mysqli,$_SERVER['PHP_SELF']);
		if(isset($_SERVER['HTTP_REFERER'])){
			$this->refer = mysqli_real_escape_string($mysqli,htmlentities($_SERVER['HTTP_REFERER'],ENT_QUOTES,"UTF-8"));
	    }
		$this->hash = mysqli_real_escape_string($mysqli,session_id());
		//$this->db = new mysqli(DBHOST, DBUSER, DBPASSWORD, )

		//check user existed!
		if($this->exist()){
			//update databse
			$this->update();
		}else if(!(strstr($this->ua,"bot")||strstr($this->ua,"spider"))){
			//if none, add this record
			$this->addRecord();
		}
		//clean the user who leave our site 
		$this->clean();
	}

	/**
	 * 
	 * return all record!
	 * 
	 * @return array
	 */
	function getAll()
	{
		$ret = array();
		
		global $mysqli;
		$sql = 'SELECT * FROM online';
		$res = mysqli_query($mysqli,$sql);
		//$sql = 'ALTER TABLE `jol`.`online` ENGINE = MEMORY';
		//$res = mysqli_query($mysqli,$sql);
		if($res ){
			while($rt = mysqli_fetch_object($res)) $ret[] = $rt;
			mysqli_free_result($res);
		}
		return $ret;
	}
	/**
	 * 
	 * return specfy record
	 * @var string ip
	 * @return object 
	 */
	function getRecord($ip)
	{
		$sql = "SELECT * FROM online WHERE ip = '$ip'";
		$res = mysqli_query($mysqli,$sql);
		if(mysqli_num_rows($res)){
			$ret = mysqli_fetch_object($res);
		}else{
			return false;
		}
		mysqli_free_result($res);
		return $ret;
	}
	
	/**
	 * 
	 * get total count
	 * 
	 * @return int
	 */
	function get_num()
	{
		global $mysqli;
		$sql = 'SELECT count(ip) as nums FROM online';
		$res = mysqli_query($mysqli,$sql);
		$ret = 0;
		if($res){
			$ret = mysqli_fetch_object($res);
			$ret = $ret->nums;
			mysqli_free_result($res);
	    }
		return $ret;
	}
	/**
	 * check the record exist
	 *
	 * @return boolean 
	 */
	function exist()
	{
		global $mysqli;
		$sql = "SELECT * FROM online WHERE hash = '$this->hash'";
		$res = mysqli_query($mysqli,$sql);
		if($res&&mysqli_num_rows($res) == 0)
			return false;
		else
			return true;

	}
	/**
	 * add a record
	 *
	 * @return void
	 */
	function addRecord()
	{
		global $mysqli;
		$now = time();
		$sql = "INSERT INTO online(hash, ip, ua, uri, refer, firsttime, lastmove)
				VALUES ('$this->hash', '$this->ip', '$this->ua', '$this->uri', '$this->refer', '$now', '$now')";
		mysqli_query($mysqli,$sql);
	}

	/**
	 * update a record
	 *
	 * @return void
	 */
	function update()
	{
		global $mysqli;
		$sql = "UPDATE online
				SET
					ua = '$this->ua',
					uri = '$this->uri',
					refer = '$this->refer',
					lastmove = '".time()."',
					ip = '$this->ip'
				WHERE
					hash = '$this->hash'
				";
		mysqli_query($mysqli,$sql);
	}
	/**
	 * clean the duration user
	 *
	 * @return void
	 */
	function clean()
	{
		global $mysqli;
		$sql = 'DELETE FROM online WHERE lastmove<'.(time()-ONLINE_DURATION);
		mysqli_query($mysqli,$sql);
	}
}
