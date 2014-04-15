<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller {

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
		$dados= array();
		$dados['linhas'] = array();
		if(!empty($_GET['listar_produtos'])){
			$dados= $this->ler_arquivo($this->session->userdata('id_ent'));
		}
		
		$dados['qtd_arquivos'] = $this->contar_arquivos($this->session->userdata('id_ent'));
		if(empty($this->session->userdata['id_ent'])){
			redirect('acesso');
		}
		else{
	
			$this->parser->parse('upload',$dados);
		}
		//echo "<pre>"; print_r($this->session->userdata); echo "</pre>";
	}
	public function upload_arquivo(){
		 /*echo "<pre>"; print_r($_REQUEST); echo "</pre>";
		 echo "<pre>"; print_r($_FILES); echo "</pre>";
		 echo "<pre>"; print_r($this->input->post()); echo "</pre>";*/
		 $output_dir = "files/".$this->session->userdata('id_ent').'/';
		if(isset($_FILES["myfile"]))
		{
			$ret = array();

			$error =$_FILES["myfile"]["error"];
			//You need to handle  both cases
			//If Any browser does not support serializing of multiple files using FormData() 
			if(!is_array($_FILES["myfile"]["name"])) //single file
			{
		 	 	$fileName = $_FILES["myfile"]["name"];
		 		move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$fileName);
		    	$ret[]= $fileName;
			}
			else  //Multiple files, file[]
			{
			  $fileCount = count($_FILES["myfile"]["name"]);
			  for($i=0; $i < $fileCount; $i++)
			  {
			  	$fileName = $_FILES["myfile"]["name"][$i];
				move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$fileName);
			  	$ret[]= $fileName;
			  }
			
			}
			//echo "<pre>"; print_r($ret); echo "</pre>";
		    echo json_encode($ret);
		 }
}

	public function contar_arquivos($id){
		 $output_dir = "files/".$id.'/';
		 return count(glob($output_dir."*"));
	}	

	public function delete_arquivo(){
		$output_dir = "uploads/";
		if(isset($_POST["op"]) && $_POST["op"] == "delete" && isset($_POST['name'])){
			$fileName =$_POST['name'];
			$filePath = $output_dir. $fileName;
			if (file_exists($filePath)){
		        unlink($filePath);
		    }
			echo "Deleted File ".$fileName."<br>";
		}
	}

	public function ler_arquivo($id){
		$feedback = array();
		$output_dir = "files/".$id.'/';
		$feedback['nome_arquivo'] = '';
		$diretorio = dir($output_dir);
		$i = 0;
		$arquivo='';
		while($arquivo2 = $diretorio->read()){
				if(strpos($arquivo2,'.')){
					$arquivo = $arquivo2;
					$feedback['nome_arquivo'] = $arquivo;
				}
		} 
		 $diretorio->close();
		$feedback['linhas'] = array();
//		$arquivo = 'arquivo.txt';
		/* 
		echo ' '.$output_dir;
		echo '<pre>'.print_r($diretorio); echo '</pre>';
		*/
		if(file_exists($output_dir.$arquivo)){
			$i=0;
			$handle = fopen($output_dir.$arquivo, "r");
			$feedback['show_erros'] = true;
			while (!feof($handle)) {
				$linha = fgets($handle, 1024);  
				$linha = explode(';',$linha);
			#	echo "<pre>"; print_r($linha); echo "</pre>";
				
				$comprimento = trim($linha['3']);
				if(empty($comprimento)){
					$linha['3'] = 16;
				}

				$largura = trim($linha['5']);
				if(empty($largura)){
					$linha['5'] = 11;
				}

				$altura = trim($linha['4']);
				if(empty($altura)){
					$linha['4'] = 2;
				}

				$peso = trim($linha['2']);
				if(empty($peso)){
					$linha['2'] = 0;
				}

				$diametro = trim($linha['6']);
				if(empty($diametro)){
					$linha['6'] = 0;
				}
				
				$feedback['linhas'][$i]['cod']             =$linha['0'];
				$feedback['linhas'][$i]['desc']            =$linha['1'];
				$feedback['linhas'][$i]['peso']            =$linha['2'];
				$feedback['linhas'][$i]['comprimento']     =$linha['3'];
				$feedback['linhas'][$i]['altura']          =$linha['4'];
				$feedback['linhas'][$i]['largura']         =$linha['5'];
				$feedback['linhas'][$i]['diametro']        =$linha['6']; 
				$feedback['linhas'][$i]['calculadora']     = base_url().'frete/lerArquivo?cod_cli='.$this->session->userdata('id_ent').'&cod_prod='.$linha['0'];
				$i++;
				#echo "<pre>"; print_r($feedback); echo "</pre>";
			}
			fclose($handle);
			$feedback['servico'] = true;
		}
		else{
			$feedback['servico'] = false;
		}
		return $feedback;
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */