<?php 
class db {

		function db_connect1(){

			$this->link1 = mysql_connect(DB_HOST,DB_USER1,DB_PASSWORD1,true);
		        @mysql_select_db(DB_NAME1);
			mysql_query("SET NAMES UTF8");

		}
		
		function db_close1(){

			mysql_close($this->link1);

		}

}

$obj_db = new db();

?>