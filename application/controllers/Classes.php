<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Classes extends SU_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->title = "Manage Classes";
		$this->scripts = array("class");
	}


	public function index()
	{	

		$teacher_where['teacher_id'] = 1;
		$data['teacher'] = $this->crud_model->get('teacher',$teacher_where);
		$class_where['array_teachers'] = 1;
		$data['classes'] = $this->crud_model->get('class',$class_where);
		$this->load->view('manage-classes',$data);
	}

	public function manage()
	{

		//get login user id helper
		//pending
		$data['class_name'] = $this->input->post('class_name');
		$data['array_teachers'] = array(1);
		$data['array_students'] = array();
		$data['last_change'] = date("Y-m-d");
		$data['standard'] = 0;
		$data['show_tools'] = array(1, 1, 1, 1, 2, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
		$data['teacher_name'] = $this->input->post('teacher_name');
		$data['classcode'] = alphanumeric(6);
		$data['connectedclass'] = array();
		$data['messages4class'] = array();
		$data['homework4class'] = array();
		$data['calendar4class'] = array();
		$data['exams4class'] = array();
		$data['links4class'] = array();
		$data['shortcuts'] = array();


		//insert in class collection
		$class_id = $this->crud_model->insert('class',$data);

		$pushColumn = 'array_classes';
		$pushData = [$class_id];
		$where['teacher_id'] = 1;
		//update teacher collection => array_classes
		$update = $this->crud_model->update('teacher',$where,'',$pushColumn,$pushData);
		if($update){
			$msg = 'Class Created Successfully';
			$response['status'] = true;
			$response['msg'] = $msg;
			$this->session->set_flashdata('success',$msg);
		}else{
			$msg = 'Something Went Wrong';
			$response['status'] = false;
			$response['msg'] = $msg;
			$this->session->set_flashdata('error',$msg);
		}
		
		redirect('classes');
	}

	public function standard()
	{	
		$class_id = $this->input->post('standart_class');
		$data['standard'] = 1;
		$class_where['_id'] = new MongoDB\BSON\ObjectID($class_id);
		$update = $this->crud_model->update('class',$class_where,$data);

		if($update){
			$msg = 'Class Standered Successfully';
			$response['status'] = true;
			$response['msg'] = $msg;
			$this->session->set_flashdata('success',$msg);
		}else{
			$msg = 'Something Went Wrong';
			$response['status'] = false;
			$response['msg'] = $msg;
			$this->session->set_flashdata('error',$msg);
		}
		redirect('classes');
	}

	public function update()
	{
		$data['class_name'] = $_POST['name'];
		$data['last_change'] = date("Y-m-d");
		$class_where['_id'] = new MongoDB\BSON\ObjectID($_POST['id']);
		//update class collection
		$update = $this->crud_model->update('class',$class_where,$data);

		if($update){
			$msg = 'Class Updated Successfully';
			$response['status'] = true;
			$response['msg'] = $msg;
			$this->session->set_flashdata('success',$msg);
		}else{
			$msg = 'Something Went Wrong';
			$response['status'] = false;
			$response['msg'] = $msg;
			$this->session->set_flashdata('error',$msg);
		}
		
		echo json_encode($response);
		exit();
	}


	public function delete()
	{
		$class_where['_id'] = new MongoDB\BSON\ObjectID($_POST['id']);
		//update class collection
		$popColumn = 'array_classes';
		$popData = [$_POST['id']];
		$where['teacher_id'] = 1;
		//update teacher collection => array_classes
		$update = $this->crud_model->update('teacher',$where,'','','',$popColumn,$popData);

		//delete all studnets in this class
		//pending 

		if($update){
			$delete = $this->crud_model->delete('class',$class_where);
			if($delete){
				$msg = 'Class Deleted Successfully';
				$response['status'] = true;
				$response['msg'] = $msg;
				$this->session->set_flashdata('success',$msg);
			}else{
				$msg = 'Something Went Wrong';
				$response['status'] = false;
				$response['msg'] = $msg;
				$this->session->set_flashdata('error',$msg);
			}
		}else{
			$msg = 'Something Went Wrong';
			$response['status'] = false;
			$response['msg'] = $msg;
			$this->session->set_flashdata('error',$msg);
		}
		
		echo json_encode($response);
		exit();
	}

	public function settings($id)
	{	

		$class_where['_id'] = new MongoDB\BSON\ObjectID($id);
		$data['class'] = $this->crud_model->get('class',$class_where);
		$this->title = "Settings Class";
		$this->load->view('settings-class',$data);
	}


	public function options()
	{
		$this->layout = '';
		$classWhere['_id'] = new MongoDB\BSON\ObjectID($_POST['class_id']);
		$data['class_tools'] = $this->crud_model->get('class',$classWhere);
		echo $this->load->view('class-options',$data,true);
	}


	public function shortcut()
	{
		$id = new MongoDB\BSON\ObjectID($this->input->post('id'));
		$shortcut = $this->input->post('shortcut');
		$pushColumn = 'shortcuts';
		$pushData = [$shortcut];
		$where['_id'] = $id;
		$update = $this->crud_model->update('class',$where,'',$pushColumn,$pushData);

		if($update){
			
			$msg = 'Shortcut added Successfully';
			$response['status'] = true;
			$response['msg'] = $msg;
			$this->session->set_flashdata('success',$msg);
		}else{
			$msg = 'Something Went Wrong';
			$response['status'] = false;
			$response['msg'] = $msg;
			$this->session->set_flashdata('error',$msg);
		}

		$redirect_url = "classes/settings/".$this->input->post('id');
		redirect($redirect_url);
	}


	public function connect_class()
	{
		$id = new MongoDB\BSON\ObjectID($this->input->post('id'));
		$class_code = $this->input->post('code');
		$classWhere['classcode'] = $class_code;
		$class = $this->crud_model->get('class',$classWhere);


		$checkCodeWhere['connectedclass'] = $class[0]['_id'];
		$checkClass = $this->crud_model->get('class',$checkCodeWhere);
		if($checkClass){
			$msg = 'This code exists. Note. Please ask the partner class to.';
			$response['msg'] = $msg;
			$this->session->set_flashdata('error',$msg);
		}else{
			$pushColumn = 'connectedclass';
			$pushData = [$class[0]['_id']];
			$where['_id'] = $id;
			$update = $this->crud_model->update('class',$where,'',$pushColumn,$pushData);

			if($update){

				$msg = 'Class Connected Successfully';
				$response['status'] = true;
				$response['msg'] = $msg;
				$this->session->set_flashdata('success',$msg);
			}else{
				$msg = 'Something Went Wrong';
				$response['status'] = false;
				$response['msg'] = $msg;
				$this->session->set_flashdata('error',$msg);
			}
		}


		$redirect_url = "classes/settings/".$this->input->post('id');
		redirect($redirect_url);
	}


	public function delete_connected_class()
	{
		
		$class_id = new MongoDB\BSON\ObjectID($_POST['id']);
		$index = $_POST['index'];

		$classWhere['_id'] = $class_id;
		$class = $this->crud_model->get('class',$classWhere);

		$connectedClasses = $class[0]['connectedclass'];

		unset($connectedClasses[$index]);
		$data['connectedclass'] = $connectedClasses;
		$where['_id'] = $class_id;
		$update = $this->crud_model->update('class',$where,$data);
		if($update){

			$msg = 'Class Connected Removed Successfully';
			$response['status'] = true;
			$response['msg'] = $msg;
			$this->session->set_flashdata('success',$msg);
		}else{
			$msg = 'Something Went Wrong';
			$response['status'] = false;
			$response['msg'] = $msg;
			$this->session->set_flashdata('error',$msg);
		}
		
		echo json_encode($response);
		exit();

	}


	public function delete_shortcuts()
	{
		
		$class_id = new MongoDB\BSON\ObjectID($_POST['id']);
		$index = $_POST['index'];

		$classWhere['_id'] = $class_id;
		$class = $this->crud_model->get('class',$classWhere);

		$shortcuts = $class[0]['shortcuts'];

		unset($shortcuts[$index]);
		$data['shortcuts'] = $shortcuts;
		$where['_id'] = $class_id;
		$update = $this->crud_model->update('class',$where,$data);
		if($update){

			$msg = 'Shortcut Removed Successfully';
			$response['status'] = true;
			$response['msg'] = $msg;
			$this->session->set_flashdata('success',$msg);
		}else{
			$msg = 'Something Went Wrong';
			$response['status'] = false;
			$response['msg'] = $msg;
			$this->session->set_flashdata('error',$msg);
		}
		
		echo json_encode($response);
		exit();

	}


}
