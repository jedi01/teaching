<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	// function __construct() {
 //        parent::Controller();
 //        $this->parts[head] = $this->load->view("frontend/global/header.php", null, true);
 //        $this->scripts = array("JQuery/jquery-1.4.2.min", "JQuery/form", "Core", "Frontend");
 //        $this->styles = array("style");
 //        $this->title = "Blah blah";
 //    }

    public function index()
	{	
		$this->load->library('mongo_db', array('activate'=>'default'),'mongo_db2');

		try {


			//with driver
			// $mng = new MongoDB\Driver\Manager("mongodb+srv://ursin-user:MS357UdXIDH5P1qu@ursin-vl750.mongodb.net/ursin?retryWrites=true&w=majority");
			// $query = new \MongoDB\Driver\Query([], []);
			// $rows   = $mng->executeQuery('ursin.users', $query);
			// echo "<pre>";

			// foreach ($rows as $document) {
			// 	print_r($document);
			// }

			//with library
			$teacher = array(
				"student_name"=>"another",
				"code"=> alphanumeric(6),
				"array_teachers"=>array(),
				"array_classes"=>array(),
				"timestamp"=>date("Y-m-d"));
			$imongo = $this->crud_model->insert("student",$teacher);
			//$imongo = $this->mongo_db2->get('users');
			print_r($imongo);



		} catch (MongoDB\Driver\Exception\Exception $e) {

			$filename = basename(__FILE__);

			echo "The $filename script has experienced an error.\n"; 
			echo "It failed with the following exception:\n";

			echo "Exception:", $e->getMessage(), "\n";
			echo "In file:", $e->getFile(), "\n";
			echo "On line:", $e->getLine(), "\n";       
		}

	}
}
