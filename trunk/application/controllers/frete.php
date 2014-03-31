<?php
class Frete extends CI_Controller{

	private $arquivoNome = 'arquivo.txt';
	private $cep_origem = '30550720';
	private $cep_destino = '';


	public function index(){
		$this->load->view('frete');
	}
	
	public function lerArquivo(){
		$cod_prod_get = $_GET['cod_prod'];
		$this->cep_destino = str_replace('-', '', $_GET['cep']);
		$largura_prod = 11;
		$arquivo = $this->arquivoNome;
		$feedback = array();
		if(file_exists('resources/txt/'.$arquivo)){
			$handle = fopen('resources/txt/'.$arquivo, "r");
			$feedback['show_erros'] = true;
			while ($userinfo = fscanf($handle, "%s\t%s\t%s\t%s\t%s\t%s\t%s\n")) {
			 //  echo "<pre>"; print_r(list ($cod_prod, $nome_prod, $peso_prod, $comprimento_prod, $altura_prod, $diametro_prod) = $userinfo); echo "</pre>";
			   list ($cod_prod, $nome_prod, $peso_prod, $comprimento_prod, $altura_prod, $diametro_prod) = $userinfo;
			  # echo "<pre>"; print_r(); echo "</pre>";
			   if($cod_prod == $cod_prod_get){
			   	$feedback['fretes'] = array();
			   	$feedback['erros'] = array();
				  // 	echo $peso_prod .' '.$comprimento_prod. ' '.$altura_prod. ' '.$diametro_prod. ' '  ;
					$servico = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=09146920&sDsSenha=123456&sCepOrigem=70002900&sCepDestino=71939360&nVlPeso=1&nCdFormato=1&nVlComprimento=30&nVlAltura=30&nVlLargura=30&sCdMaoPropria=n&nVlValorDeclarado=0&sCdAvisoRecebimento=n&nCdServico=40010,40045,40215,40290,41106&nVlDiametro=0&StrRetorno=xml&nIndicaCalculo=3";
				   	#echo "<br /><br /><br /><br />".$servico. "<br /><br /><br /><br /><br />";
				   	$servico = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=09146920&sDsSenha=123456&sCepOrigem=".$this->cep_origem."&sCepDestino=".$this->cep_destino."&nVlPeso=".$peso_prod."&nCdFormato=1&nVlComprimento=".$comprimento_prod."&nVlAltura=".$altura_prod."&nVlLargura=".$largura_prod."&sCdMaoPropria=n&nVlValorDeclarado=0&sCdAvisoRecebimento=n&nCdServico=40010,40045,40215,40290,41106&nVlDiametro=". $diametro_prod."&StrRetorno=xml&nIndicaCalculo=3";
				  # 	echo "<br /><br /><br /><br /><br />".$servico . "<br /><br /><br /><br /><br /><br />";

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
		return $feedback;
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

		$a = new Frete();
		$result = $a->lerArquivo($_REQUEST);
?>

	<?php
		
		if(!empty($result['fretes'])){
	?>
			<div class="list-group">
	  			<a href="#" class="list-group-item active">
    			<h4 class="list-group-item-heading">Fretes Disponíveis</h4>
  			</a>

	<?php
			foreach ($result['fretes'] as $key => $value) {
			?>
			  <a href="#" class="list-group-item">
			    <h4 class="list-group-item-heading"><?php echo $value['nome_frete'];?></h4>
			    <p class="list-group-item-text">R$ <?php echo $value['valor'];?></p>
			    <p class="list-group-item-text"><?php echo $value['prazo'];?> dias</p>
			  </a>
			<?php
			} ?> 
			</div>
			<?php
		}
		if(!empty($result['erros']) && $result['show_erros']){
			?>
					<hgroup class="bs-callout bs-callout-warning" id="servicoErro">
					    <h4> Possíveis Problemas </h4>
			<?php
					foreach ($result['erros'] as $key => $value) {
					?>
						<h5><?php echo $value['msg'];?></h5>
					<?php
						} 
					?> 
					</hgroup>
					<?php
				}
		?>
	
