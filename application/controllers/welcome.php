<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {


	public function index()
	{
        $viewData  = "Welcome to D&R";


		$this->load->view('view_control',$viewData);
	}
	public function getMessage(){

		echo "Burasi methoddur";

	}

}
