<?php
class Frete extends CI_Controller{

	private $arquivoNome = 'arquivo.txt';
	private $cep_origem = '30550720';
	private $cep_destino = '';
	private $feedback ;

	public function index(){
		$feedback 	= array();
		$feedback['dados_produtos'] = '';
		$p = new Produtos();
		$feedback['possui_produto_indicado'] = 'display:none;';
		
		if(empty($_GET['cod_cli'])){
			$feedback['possui_parametros'] = 'display:none;';
			$feedback['erro_cliente'] = 'display:none;';
			$feedback['possui_parametros_mostra'] = '';			
			$feedback['possui_parametros_msg'] = '<code>Cliente</code> não indicado';			
		}
		else if(empty($_GET['cod_prod'])){
			$feedback['possui_parametros'] = 'display:none;';
			$feedback['possui_parametros_mostra'] = '';		
			$feedback['possui_parametros_msg'] = '<code>Produto</code> não indicado';			
		} 
		else if(empty($_GET['cep'])){
			$feedback['possui_parametros_mostra'] = '';			
			$feedback['possui_parametros_msg'] = '<code>CEP</code> não indicado';
			$feedback['erro_cliente'] = 'display:none;';			
		}
		if(!empty($_GET['cod_prod'])){
			$dados_prod = $p->get_produto_by_id($_GET['cod_prod']);
			#echo "<pre>";print_r($dados_prod);echo "</pre>";
			if(!empty($dados_prod)){
				$feedback['dados_produtos'] = $dados_prod;
				$feedback['possui_produto_indicado'] = '';
			}
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
		$feedback['erro_cliente'] = 'display:none;';
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
		$p = new Produtos();
			$dados_prod = $p->get_produto_by_id($_GET['cod_prod']);
			#echo "<pre>";print_r($dados_prod);echo "</pre>";
			if(!empty($dados_prod)){
				$feedback['dados_produtos'] = $dados_prod;
				$feedback['possui_produto_indicado'] = '';
			}

		if(empty($_GET['cep'])){
			$feedback['possui_parametros_mostra'] = '';			
			$feedback['possui_parametros_msg'] = '<code>CEP</code> não indicado';			
		}
		else{

			$this->cep_destino = str_replace('-', '', $_GET['cep']);		

			$largura_prod = 11;
			
	//		$arquivo = $this->arquivoNome;

			//$output_dir = "files/".$cod_cli_get.'/';
			

			//$diretorio = dir($output_dir);
			//$arquivo='';
			/*while($arquivo2 = $diretorio->read()){
					if(strpos($arquivo2,'.')){
						$arquivo = $arquivo2;
					}
			} */

		$dados_produto_consulta = $dados_prod;

			/*echo "<pre>";
			print_r($dados_produto_consulta);
			echo "</pre>";*/
			//if(file_exists($output_dir.$arquivo)){
			if(!empty($dados_produto_consulta)){

				//$handle = fopen($output_dir.$arquivo, "r");
				$feedback['show_erros'] = true;
				
				//while (!feof($handle)) {
					//$linha = fgets($handle, 1024);  
				//$linha = explode(';',$linha);
	//				echo "<pre>"; print_r($linha); echo "</pre>";
					//$comprimento = trim($linha['3']);
					$comprimento = trim($dados_produto_consulta[0]['comprimento']);

					if(empty($comprimento) || $comprimento == 0.000){
						//$linha['3'] = 16;
						$comprimento = 16;

					}

					//$largura = trim($linha['5']);
					$largura = trim($dados_produto_consulta[0]['largura']);

					if(empty($largura) || $largura == 0.000){
						//$linha['5'] = 11;
						$largura = 11;
					}

					//$altura = trim($linha['4']);
					$altura = trim($dados_produto_consulta[0]['altura']);
					if(empty($altura) || $altura == 0.000){
					//	$linha['4'] = 2;
						$altura = 2;
					}

					//$peso = trim($linha['2']);
					$peso = trim($dados_produto_consulta[0]['peso']);
					if(empty($peso)  || $peso == 0.000){
						//$linha['2'] = 0;
						$peso = 0;
					}

					//$diametro = trim($linha['6']);
					$diametro = trim($dados_produto_consulta[0]['diametro']);
					if(empty($diametro)  || $diametro == 0.000){
						//$linha['6'] = 0;
						$diametro = 0;
					}

				 //  if($linha['0'] == $cod_prod_get){
					  // 	echo $peso_prod .' '.$comprimento_prod. ' '.$altura_prod. ' '.$diametro_prod. ' '  ;
						#$servico = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=09146920&sDsSenha=123456&sCepOrigem=70002900&sCepDestino=71939360&nVlPeso=1&nCdFormato=1&nVlComprimento=30&nVlAltura=30&nVlLargura=30&sCdMaoPropria=n&nVlValorDeclarado=0&sCdAvisoRecebimento=n&nCdServico=40010,40045,40215,40290,41106&nVlDiametro=0&StrRetorno=xml&nIndicaCalculo=3";
					   	#echo "<br /><br /><br /><br />".$servico. "<br /><br /><br /><br /><br />";
					   	//$servico = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=09146920&sDsSenha=123456&sCepOrigem=".$this->cep_origem."&sCepDestino=".$this->cep_destino."&nVlPeso=".$linha['2']."&nCdFormato=1&nVlComprimento=".$linha['3']."&nVlAltura=".$linha['4']."&nVlLargura=".$largura_prod."&sCdMaoPropria=n&nVlValorDeclarado=0&sCdAvisoRecebimento=n&nCdServico=40010,40045,40215,40290,41106&nVlDiametro=". $linha[6]."&StrRetorno=xml&nIndicaCalculo=3";
					   	$servico = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=09146920&sDsSenha=123456&sCepOrigem=".$this->cep_origem."&sCepDestino=".$this->cep_destino."&nVlPeso=".$peso."&nCdFormato=1&nVlComprimento=".$comprimento."&nVlAltura=".$altura."&nVlLargura=".$largura."&sCdMaoPropria=n&nVlValorDeclarado=0&sCdAvisoRecebimento=n&nCdServico=40010,40045,40215,40290,41106&nVlDiametro=".$diametro."&StrRetorno=xml&nIndicaCalculo=3";
					 #  	echo "<br /><br /><br /><br /><br />".$servico . "<br /><br /><br /><br /><br /><br />";


						$ch = curl_init();  

						curl_setopt($ch,CURLOPT_URL, $servico);
						curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

						$output = curl_exec($ch);

						curl_close($ch);

						$xml = simplexml_load_string($output);

					   	if (!$xml) {
						  $feedback['erros'][999]['msg'] = 'Correio indisponível tente novamente mais tarde';
						}
						else{
						   	#echo "<pre>";print_r($xml);echo "</pre>";
							$i=0;
							foreach ($xml->cServico as $key=>$v) {
								if($v->Valor != '0,00'){
									$feedback['show_erros'] = false;
									$feedback['fretes'][$i]['nome_frete'] =$this->converteServico($v->Codigo);
									$feedback['fretes'][$i]['prazo'] = $v->PrazoEntrega;
									$feedback['fretes'][$i]['valor'] = $v->Valor;
								}
								else{
									$feedback['erros'][$i]['msg'] = $v->MsgErro;
								}
								$i++;
							}
						   	 #echo "<pre>"; print_r($xml); echo "</pre>";

				   		}
				   		//libxml_clear_errors();
						//libxml_use_internal_errors($use_errors);
				   //}
				//}
				//fclose($handle);

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
			#echo "<pre>";print_r($feedback);echo "</pre>";
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

	function autosuggest_produtos(){
		$p = new Produtos();
		echo json_encode($p->get_like_nome_produto($_REQUEST['term']));
		//echo json_encode($p->get_todos_produtos());
	//echo '[{"label":"Arwen", "actor":"Liv Tyler"}]';
	}
}
?>