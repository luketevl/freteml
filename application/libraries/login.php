<?php
class Login{

	function Login(){
		$this->CI =& get_instance();
		$this->session = & $this->CI->session;
	}

	public function is_logado(){
		$email_sessao = $this->session->userdata('email_usu');
		if(!empty($email_sessao)){
			return true;
		}
		return false;
	}

	public function criarSessao($e){
	 	//echo "<pre>"; print_r($e); echo "</pre>";
		$id = (empty($e->id))? $e->stored->id_usu : $e->id;
		$this->session->set_userdata('id_ent',$id);
		$this->session->set_userdata('nome_usu',$e->stored->nome_usu);
		$this->session->set_userdata('email_usu',$e->stored->email_usu);
		//echo "<pre>"; print_r($this->session->userdata); echo "</pre>";die;
	}
	public function deslogar(){
		$this->session->sess_destroy();
		redirect("welcome");
	}
}