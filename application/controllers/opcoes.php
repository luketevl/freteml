<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Opcoes extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index(){
		$id = $this->session->userdata['id_ent'];
		if(!empty($id)){
			$dados = array();
			$o = new Opcao();
			$o = $o->existe_opcoes($id);
			$id_opc = $o->stored->id_opc;
			$dados = $o->stored;
			$this->parser->parse('opcoes',$dados);	
		}
			//echo "<pre>"; print_r($o); echo "</pre>";die;
		else{
			redirect('acesso');
		}
	}

	public function save(){
		$_data = $this->input->post();
		$_data['id_usu'] = $this->session->userdata('id_ent');
		$o = new Opcao();
		$o = $o->salvar($_data);
		$id_opc = $o->stored->id_opc;
		if(!empty($id_opc)){
			redirect('upload');	
		}
		else{
			$this->index();
		}

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */