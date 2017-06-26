<?php
	class databaseConnect {
		function connect(){
			global $dbh;
			require_once('mysql_config.php');
			try {
			global $dbh;
			$dbh = new PDO("mysql:host=".$db_specs['db_host'].";
					dbname=".$db_specs['db_database'].";charset=utf8",
					$db_specs['db_user'],
					$db_specs['db_passwd']);
			}
				catch (PDOException $e) { die ("Virhe: ".$e->getMessage() ) ;
			}
		}
		public function getDBH(){
			global $dbh;
			return $dbh;
		}
		
	}
?>