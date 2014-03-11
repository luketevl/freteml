<?php
class Acesso extends CI_Controller{
 	
	public function index(){
		$this->load->view('login_vw');
	}
	public function logar(){
		$feedback = array();
	 	$_data = $this->input->post();
	 	// echo "<pre>"; print_r($_data); echo "</pre>";
	 	$u = new Usuario();
	 	$u = $u->verifica_login($_data['email'], $_data['senha']);
//	 	echo "<pre>"; print_r($u); echo "</pre>";
	 	if($u->exists()){
	 	}
	 	else {
	 		echo 'Usuario ou senha incorretos';
	 	}
	 //	echo json_encode($feedback);
	 }

	public function cadastrar(){
		$feedback = array();
	 	$_data = $this->input->post();
	 	// echo "<pre>"; print_r($_data); echo "</pre>";
	 	$u = new Usuario();
	 	$u = $u->verifica_login($_data['email'], $_data['senha']);
//	 	echo "<pre>"; print_r($u); echo "</pre>";
	 	if($u->exists()){
	 		echo 'O e-mail informado já está cadastrado';
	 	}
	 //	echo json_encode($feedback);
	 }
}
?>