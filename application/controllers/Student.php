<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends SU_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->title = 'Manage Students';
		$this->scripts = array('student');
	}


    public function index()
	{	
		$where['array_teachers'] = 1;
		$data['classes'] = $this->crud_model->get('class',$where);
		$students = $this->crud_model->get('student',$where);
		$student_array = array();

		foreach ($students as $student) { 
          $class_info = class_info($student['array_classes'][0]);
          $info = array('student_name' => $student['student_name'],
          	'class_name'=> $class_info['class_name'],
          	'student_id'=>$student['_id'],
          	'student_code' => $student['code'],
          	'student_emails' => $student['parents_email']
          );
          array_push($student_array,$info);
      	}

      	$sorting = array_column($student_array, 'class_name');
        array_multisort($sorting, SORT_ASC, $student_array);
        $data['student_info'] = $student_array;
		$this->load->view('manage-students',$data);
	}

	public function manage()
	{	
		$class_id = $this->input->post('class_id');
		$student_names = $this->input->post('student_names');
		$student_names_with_next_lines = explode("\n", $student_names);
		$student_full_names = array();
		foreach ($student_names_with_next_lines as $key => $value) {
			$student_with_comma_seprate = explode(",",$value);
			foreach ($student_with_comma_seprate as $k => $v) {
				array_push($student_full_names, $v);
			}
			
			
		}

		foreach ($student_full_names as $student_name) {
			$data['student_name'] = $student_name;
			$data['code'] = alphanumeric(6);
			$data['parents-code'] = alphanumeric(6);
			$data['array_classes'] =  array($class_id);
			$data['array_teachers'] = array(1);
			$data['timestamp'] = date('Y-m-d');
			$data['parents_email'] = array();
			$data['sick'] =  array();
			//insert in student collection
			$student_id = $this->crud_model->insert('student',$data);

			$pushColumn = 'array_students';
			$pushData = [$student_id];
			$where['teacher_id'] = 1;
			//update teacher collection => array_students
			$this->crud_model->update('teacher',$where,'',$pushColumn,$pushData);


			$classWhere['_id'] = new MongoDB\BSON\ObjectID($class_id);
			//update class collection => array_students
			$update = $this->crud_model->update('class',$classWhere,'',$pushColumn,$pushData);

			if($update){
				$msg = 'Students Created Successfully';
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
		redirect('student');
	}

	public function transfer()
	{
		$student_name = $_POST['student_name'];
		$code = $_POST['code'];
		$class_id = $_POST['class_id'];
		$where['code'] = $code;
		$where['student_name'] = $student_name;
		$student = $this->crud_model->get('student',$where);
		if(!empty($student)){
			$student_id = $student[0]['_id'];
			$pushColumn = 'array_students';
			$pushData = [$student_id];
			$where['teacher_id'] = 1;

			//update teacher collection => array_students
			$this->crud_model->update('teacher',$where,'',$pushColumn,$pushData);

			$classWhere['_id'] = new MongoDB\BSON\ObjectID($class_id);

			//update class collection => array_students
			$this->crud_model->update('class',$classWhere,'',$pushColumn,$pushData);

			$student_where['_id'] = new MongoDB\BSON\ObjectID($student_id);
			$pushClassColumn = 'array_classes';
			$pushClass = [$class_id];
			$this->crud_model->update('student',$student_where,'',$pushClassColumn,$pushClass);

			$pushTeacherColumn = 'array_teachers';
			$pushTeacher = [1];
			$this->crud_model->update('student',$student_where,'',$pushTeacherColumn,$pushTeacher);

			$response['status'] = true;
			$response['msg'] = $student_name.' was successfully transfered.';

		}else{
			$response['status'] = false;
			$response['msg'] = 'The student does not existist and can not be copied.';
		}

		echo json_encode($response);
		exit();

	}


	public function setting($id)
	{	
		$student_where['_id'] = new MongoDB\BSON\ObjectID($id);
		$data['student'] = $this->crud_model->get('student',$student_where);
		$this->title = "Settings Students";
		$this->load->view('settings-students',$data);
	}

	public function family_emails()
	{
		$student_id = new MongoDB\BSON\ObjectID($this->input->post('student_id'));
		$emails = $this->input->post();
		unset($emails['student_id']);
		$student_where['_id'] = $student_id;


		$student_where['_id'] = $student_id;
		$update_data['parents_email'] = [$emails]; 
		$update = $this->crud_model->update('student',$student_where,$update_data);
		if($update){
			$msg = 'Students Emails Added Successfully';
			$response['status'] = true;
			$response['msg'] = $msg;
			$this->session->set_flashdata('success',$msg);
		}else{
			$msg = 'Something Went Wrong';
			$response['status'] = false;
			$response['msg'] = $msg;
			$this->session->set_flashdata('error',$msg);
		}

		$redirect_url = "student/setting/".$this->input->post('student_id');
		redirect($redirect_url);


	}

	public function change_code()
	{
		$data['code'] = alphanumeric(6);
		$student_where['_id'] = new MongoDB\BSON\ObjectID($_POST['id']);
		$update = $this->crud_model->update('student',$student_where,$data);
		if($update){
			$msg = 'Password successfully changed! New password for '.$_POST['student'].' : '.strval($data['code']).'';
			$string = trim(preg_replace('/\s\s+/', ' ', $msg));
			$response['status'] = true;
			$response['msg'] = $string;
			$this->session->set_flashdata('success',$string);
		}else{
			$msg = 'Something Went Wrong';
			$response['status'] = false;
			$response['msg'] = $msg;
			$this->session->set_flashdata('error',$msg);
		}

		echo json_encode($response);
		exit();
	}


	public function change_parent_code()
	{
		$data['parents-code'] = alphanumeric(6);
		$student_where['_id'] = new MongoDB\BSON\ObjectID($_POST['id']);
		$update = $this->crud_model->update('student',$student_where,$data);
		if($update){
			$msg = 'Parents-code successfully changed! ';
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

	public function student()
	{
		$where['array_teachers'] = 1;
		$data['classes'] = $this->crud_model->get('class',$where);

		$classWhere['array_teachers'] = 1;
		$classWhere['standard'] = 1;
		$data['class_tools'] = $this->crud_model->get('class',$classWhere);
		
		$this->title = "Student Page";
		$this->load->view('student-page',$data);
	}

	public function options()
	{
		
		$classTools['_id'] = new MongoDB\BSON\ObjectID($_POST['class_id']);
		$class_tools = $this->crud_model->get('class',$classTools,array('show_tools'));
		$tools = $class_tools[0]['show_tools'];
		unset($tools[(int)$_POST['index']]);
		$tools[(int)$_POST['index']] = (int)$_POST['value'];
		$data['show_tools'] = $tools;
		$classWhere['_id'] = new MongoDB\BSON\ObjectID($_POST['class_id']);
		$update = $this->crud_model->update('class',$classWhere,$data);
		if($update){

			$response['status'] = true;

		}else{
		
			$response['status'] = false;
			
		}

		echo json_encode($response);
		exit();


		
	}



	public function print_codelist()
	{	
		$this->layout = '';
		$data = $this->input->post();
		$class_id = $data['class'];
		$class['_id'] = new MongoDB\BSON\ObjectID($class_id);
		$class_data = $this->crud_model->get('class',$class);
		$class_students = $class_data[0]['array_students'];
		$data['students'] = array();
		foreach ($class_students as $k => $v) {
			$student_info = student_info($v);
			array_push($data['students'], $student_info);

		}

		$this->load->view('codelist',$data);   
		
        $html = $this->output->get_output();
        $this->pdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $this->pdf->setPaper('A4', 'portrait');

        $this->pdf->set_option('enable_html5_parser', TRUE);

        $this->pdf->set_option('isPhpEnabled', true);

        $this->pdf->set_option('defaultFont', 'Montserrat');

        // Render the HTML as PDF
        $this->pdf->render();

        $file =  $this->pdf->output();
        $append = alphanumeric(4);
        // Get the generated PDF file contents
        $filename = "codelist-".$append.".pdf";
        $this->pdf->stream($filename,array("Attachment"=>0));
	}

		public function delete()
	{
		$_POST['id'];
		$popStudentClassColumn = 'array_students';
		$popStudentClass = [$_POST['id']];
		$this->crud_model->update('class','','','','',$popStudentClassColumn,$popStudentClass);

		$popStudentTeacherColumn = 'array_students';
		$popStudentTeacher = [$_POST['id']];
		$this->crud_model->update('teacher','','','','',$popStudentTeacherColumn,$popStudentTeacher);

		$where['_id'] = new MongoDB\BSON\ObjectID($_POST['id']);
		$delete = $this->crud_model->delete('student',$where);
		if($delete){
			$msg = 'Student successfully Deleted! ';
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
