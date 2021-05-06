<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', false);
include './adminer-4.7.8-en.php';

function adminer_object() {

	class AdminerSoftware extends Adminer {
		function name() {
			// custom name in title and heading
			return 'Software';
		}
		function credentials() {

			if (isset($_GET['sqlite'])) {
			  //return array('localhost', 'ODBC', '');
			} else {
			  //return array('localhost', 'root', '123456');

			}
		}
		function login($login, $password) {

			if (array_key_exists("sqlite",$_GET)) {
				if(($login === 'admin') && ($password === '951753db')){
					return true;
				}
				return false;

			}
			return true;
		}

		function get_sqlite() {


			$path = "../blog/wp-content/database/";
			$files = array_values(array_diff(scandir($path), array('.', '..')));
			$empty_array = [];
			foreach($files as $file)
			{
				if( is_file($path.$file) && (strpos($file, 'sqlite') || strpos($file, 'db')))
				{
					$empty_array[] = $path.$file;
				}
			}

			$empty_array = $this->get_sqlite2($empty_array);

			return $empty_array;
		}

		function get_sqlite2($empty_array) {

			$path = "../../src/manage/db/";
			$files = array_values(array_diff(scandir($path), array('.', '..')));

			foreach($files as $file)
			{
				if( is_file($path.$file) && (strpos($file, 'sqlite') || strpos($file, 'db')))
				{
					$empty_array[] = $path.$file;
				}
			}

			return $empty_array;
		}

		function databases($flush = true) {
			if (isset($_GET['sqlite']))
				return $this->get_sqlite();
			return get_databases($flush);
		}
	}

	return new AdminerSoftware;
}
