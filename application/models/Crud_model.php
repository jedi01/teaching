<?php

class Crud_model extends CI_Model{

	public function __construct() {
		parent::__construct();
		$this->load->library('mongo_db', array('activate'=>'default'),'mongo_db2');
	}


	public function insert($collection,$data)
	{
 		try {

   		$insert = $this->mongo_db2->insert($collection,$data);
   		return $insert;

   		} catch (MongoDB\Driver\Exception\Exception $e) {

			$filename = basename(__FILE__);

			echo "The $filename script has experienced an error.\n"; 
			echo "It failed with the following exception:\n";
			echo "Exception:", $e->getMessage(), "\n";
			echo "In file:", $e->getFile(), "\n";
			echo "On line:", $e->getLine(), "\n";       
		}
	}

	public function insert_batch($collection,$data)
	{
 		try {

   		$insert_batch = $this->mongo_db2->batch_insert ($collection,$data);
   		return $insert_batch;

   		} catch (MongoDB\Driver\Exception\Exception $e) {

			$filename = basename(__FILE__);

			echo "The $filename script has experienced an error.\n"; 
			echo "It failed with the following exception:\n";
			echo "Exception:", $e->getMessage(), "\n";
			echo "In file:", $e->getFile(), "\n";
			echo "On line:", $e->getLine(), "\n";       
		}
	}

	public function update($collection,$where="",$data="",$push="",$pushData="",$pop="",$popData="")
	{	
		try {
			if(!empty($where))
				$this->mongo_db2->where($where);
			if(!empty($push)){
				$this->mongo_db2->pushAll($push,$pushData);
			}
			if(!empty($pop)){
				$this->mongo_db2->pop($pop,$popData);
			}
			if(!empty($data)){
				$this->mongo_db2->set($data);
			}
			$update = $this->mongo_db2->update($collection);
			return $update;

		} catch (MongoDB\Driver\Exception\Exception $e) {

			$filename = basename(__FILE__);

			echo "The $filename script has experienced an error.\n"; 
			echo "It failed with the following exception:\n";
			echo "Exception:", $e->getMessage(), "\n";
			echo "In file:", $e->getFile(), "\n";
			echo "On line:", $e->getLine(), "\n";       
		}
	}

	

	public function get($collection,$where='',$select="",$where_in="",$like='',$order_by='',$order='DESC',$limit='')
	{	
		try {
		if(!empty($select))
			$this->mongo_db2->select($select);
		if(!empty($where))
			$this->mongo_db2->where($where);
		if(!empty($where_in))
			$this->mongo_db2->where_in($where_in);
		if(!empty($like))
			$this->mongo_db2->like($like);
		if(!empty($order_by))
			$this->mongo_db2->sort($order_by,$order);
		if(!empty($limit))
			$this->mongo_db2->limit($limit);

		$data = $this->mongo_db2->get($collection);
		return $data;

		} catch (MongoDB\Driver\Exception\Exception $e) {

			$filename = basename(__FILE__);

			echo "The $filename script has experienced an error.\n"; 
			echo "It failed with the following exception:\n";
			echo "Exception:", $e->getMessage(), "\n";
			echo "In file:", $e->getFile(), "\n";
			echo "On line:", $e->getLine(), "\n";       
		}

	}


	public function delete($collection,$where)
	{
		try {
			$this->mongo_db2->where($where);
			$this->mongo_db2->delete($collection);
			return true;

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



?>