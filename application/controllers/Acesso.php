<?php
class Acesso extends CI_Controller{
 	
	public function index(){
		$this->load->view('login_vw');
	}
	public function logar(){
	 	echo "oi";
	 }
}
?>