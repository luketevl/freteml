<?php
class Acesso extends CI_Controller{
 	
	public function index(){
		echo "oi";
		echo "<pre>"; print_r($this->session->userdata); echo "</pre>";
		if(!empty($this->session->userdata['id_ent'])){
			redirect('upload');
		}
		else{
			$this->load->view('login_vw');
		}
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
	 	//echo "<pre>"; print_r($_data); echo "</pre>";
	 	$u = new Usuario();
	 	$u = $u->verifica_email($_data['email']);
	 //	echo "<pre>"; print_r($_data); echo "</pre>";
	 	if($u->exists()){
	 		$feedback['cod'] = '-1';
	 		$feedback['msg'] = 'O e-mail informado já está cadastrado';
	 		//echo 'O e-mail informado já está cadastrado';
	 	}
	 	else{
	 		$u = $u->inserir_usuario($_data);
	 		$this->login->criarSessao($u);
	 		mkdir('files/'.$u->id,0777);
	 		$feedback['cod'] = '1';
	 		$feedback['msg'] = 'Usuário cadastrado com sucesso';
	 	}
	 	echo json_encode($feedback);
	 }

	 public function deslogar(){
		$this->login->deslogar();
	}
}
?>