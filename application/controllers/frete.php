<?php
class Frete extends CI_Controller{

	private $arquivoNome = 'arquivo.txt';
	private $cep_origem = '30550720';
	private $cep_destino = '';
	private $feedback ;

	public function index(){
		$feedback 	= array();

		if(empty($_GET['cod_prod'])){
			$feedback['possui_parametros'] = 'display:none;';
			$feedback['possui_parametros_mostra'] = '';		
			$feedback['possui_parametros_msg'] = '<code>Produto</code> não indicado';			
		} 
		else if(empty($_GET['cod_cli'])){
			$feedback['possui_parametros'] = 'display:none;';
			$feedback['possui_parametros_mostra'] = '';			
			$feedback['possui_parametros_msg'] = '<code>Cliente</code> não indicado';			
		}
		else if(empty($_GET['cep'])){
			$feedback['possui_parametros_mostra'] = '';			
			$feedback['possui_parametros_msg'] = '<code>CEP</code> não indicado';			
		}
		$feedback['exibe_fretes'] = 'display:none;';	
		$feedback['exibe_erros'] = 'display:none;';	
		#  	 echo "<pre>"; print_r($feedback); echo "</pre>";
		  	 
		$this->parser->parse('frete',$feedback);
	}
	
	public function lerArquivo(){
		$feedback 	= array();
		$o = new Opcao();
		$feedback['fretes'] = array();
		$feedback['erros'] = array();
		$feedback['exibe_fretes'] = 'display:none;';	
		$feedback['exibe_erros'] = 'display:none;';	
		$o = $o->existe_opcoes($this->session->userdata('id_ent'));
		if(empty($_GET['cod_prod'])){
			$feedback['possui_parametros'] = 'display:none;';			
			return $feedback;
		} 
		else if(empty($_GET['cod_cli'])){
			$feedback['possui_parametros'] = 'display:none;';			
			return $feedback;
		}
		$cod_prod_get = $_GET['cod_prod'];
		$cod_cli_get = $_GET['cod_cli'];
		if(!empty($o->stored->cep_origem)){
			$this->cep_origem = str_replace('-', '', $o->stored->cep_origem);		
		}
		if(empty($_GET['cep'])){
			$feedback['possui_parametros_mostra'] = '';			
			$feedback['possui_parametros_msg'] = '<code>CEP</code> não indicado';			
			

		}
		else{

			$this->cep_destino = str_replace('-', '', $_GET['cep']);		

			$largura_prod = 11;
			
	//		$arquivo = $this->arquivoNome;

			$output_dir = "files/".$cod_cli_get.'/';
			
			$diretorio = dir($output_dir);
			$arquivo='';
			while($arquivo2 = $diretorio->read()){
					if(strpos($arquivo2,'.')){
						$arquivo = $arquivo2;
					}
			} 

			
			if(file_exists($output_dir.$arquivo)){
				$handle = fopen($output_dir.$arquivo, "r");
				$feedback['show_erros'] = true;
				
				while (!feof($handle)) {
					$linha = fgets($handle, 1024);  
					$linha = explode(';',$linha);
	//				echo "<pre>"; print_r($linha); echo "</pre>";
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

				   if($linha['0'] == $cod_prod_get){
					  // 	echo $peso_prod .' '.$comprimento_prod. ' '.$altura_prod. ' '.$diametro_prod. ' '  ;
						$servico = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=09146920&sDsSenha=123456&sCepOrigem=70002900&sCepDestino=71939360&nVlPeso=1&nCdFormato=1&nVlComprimento=30&nVlAltura=30&nVlLargura=30&sCdMaoPropria=n&nVlValorDeclarado=0&sCdAvisoRecebimento=n&nCdServico=40010,40045,40215,40290,41106&nVlDiametro=0&StrRetorno=xml&nIndicaCalculo=3";
					   	#echo "<br /><br /><br /><br />".$servico. "<br /><br /><br /><br /><br />";
					   	$servico = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=09146920&sDsSenha=123456&sCepOrigem=".$this->cep_origem."&sCepDestino=".$this->cep_destino."&nVlPeso=".$linha['2']."&nCdFormato=1&nVlComprimento=".$linha['3']."&nVlAltura=".$linha['4']."&nVlLargura=".$largura_prod."&sCdMaoPropria=n&nVlValorDeclarado=0&sCdAvisoRecebimento=n&nCdServico=40010,40045,40215,40290,41106&nVlDiametro=". $linha[6]."&StrRetorno=xml&nIndicaCalculo=3";
					 #  	echo "<br /><br /><br /><br /><br />".$servico . "<br /><br /><br /><br /><br /><br />";

					   	$xml = simplexml_load_file($servico);
						foreach ($xml->cServico as $key=>$v) {
							if($v->Valor != '0,00'){
								$feedback['show_erros'] = false;
								$feedback['fretes'][$key]['nome_frete'] =$this->converteServico($v->Codigo);
								$feedback['fretes'][$key]['prazo'] = $v->PrazoEntrega;
								$feedback['fretes'][$key]['valor'] = $v->Valor;
							}
							else{
								$feedback['erros'][$key]['msg'] = $v->MsgErro;
							}
						}
					 #  	 echo "<pre>"; print_r($xml); echo "</pre>";

					   	break;
				   }
				}
				fclose($handle);

				$feedback['servico'] = true;
			}
			else{
				$feedback['servico'] = false;
			}

			if(!empty($feedback['erros']) && $feedback['show_erros']){
				$feedback['exibe_erros'] = '';
			}
			else{
				$feedback['exibe_erros'] = 'display:none;';	
			}
			if(!empty($feedback['fretes'])){
				$feedback['exibe_fretes'] = '';	
			}
			else{
				$feedback['exibe_fretes'] = 'display:none;';	
			}
		}
		$feedback['possui_parametros_mostra'] = 'display:none';
		  	 $this->parser->parse('frete',$feedback);
	}

	public function converteServico($cod){
		switch ($cod) {
			case '40010':
				return 'SEDEX';
				break;

			case '40045':
				return 'SEDEX a Cobrar';
				break;

			case '40215':
				return 'SEDEX 10';
				break;

			case '40290':
				return 'SEDEX Hoje';
				break;

			case '41106':
				return 'PAC';
				break;

			default:
				return "Serviço Indisponível";
				break;
		}
	}
}
?>