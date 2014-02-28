<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Responsive Retina-Friendly Menu with different, size-dependent layouts" />
		<meta name="keywords" content="responsive menu, retina-ready, icon font, media queries, css3, transition, mobile" />
		<meta name="author" content="Codrops" />
		<title>Calculador de Frete</title>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="resources/css/bootstrap.min.css">

		<link rel="stylesheet" href="resources/css/doc.css">

		<!-- Optional theme -->
		<link rel="stylesheet" href="resources/css/bootstrap-theme.min.css">

		<link rel="stylesheet" href="resources/css/normalize.css">
		<!-- 
		Latest compiled and minified JavaScript -->
		<script src="resources/js/bootstrap.min.js"></script>
	</head>
	<body>
	<?php
		$a = new FreteMl();
		$result = $a->lerArquivo($_GET);
		if($result['servico']){
			?>
			<hgroup class="bs-callout bs-callout-info">
				<h4> Cálculo do Frete </h4>
				<h5>O cálculo do frete é feito diretamente com os correios.</h5>
			 </hgroup>

					 <div class="col-lg-3">
					    <div class="input-group">

						  <span class="input-group-addon">CEP</span>
						  <input type="text" class="form-control" id="cep" name="cep" placeholder="00000-000" />
						  	<span class="input-group-btn">
						    	<button class="btn btn-default" type="button"><span class="glyphicon glyphicon-usd"></span> Calcular Frete</button>
					      	</span>
					    </div>
					</div>
<section style="float:right;">
	
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
</section>
		<?php
		}
		else {
			?>
			<hgroup class="bs-callout bs-callout-danger">
						<h4> Serviço Indisponível </h4>
						 <h5>No momento não é possível carregar o frete deste produto.</h5>
				 </hgroup>
			<?php
		}
	?>

	</body>
</html>

<?php

class FreteMl {

	private $arquivoNome = 'arquivo.txt';
	private $cep_origem = '30550720';
	private $cep_destino = '';

	public function lerArquivo($_GET){
		$cod_prod_get = $_GET['cod_prod'];
		$this->cep_destino = $_GET['cep'];
		$largura_prod = 11;
		$arquivo = $this->arquivoNome;
		$feedback = array();
		if(file_exists('resources/txt/'.$arquivo)){
			$handle = fopen('resources/txt/'.$arquivo, "r");
			while ($userinfo = fscanf($handle, "%s\t%s\t%s\t%s\t%s\t%s\t%s\n")) {
			 //  echo "<pre>"; print_r(list ($cod_prod, $nome_prod, $peso_prod, $comprimento_prod, $altura_prod, $diametro_prod) = $userinfo); echo "</pre>";
			   list ($cod_prod, $nome_prod, $peso_prod, $comprimento_prod, $altura_prod, $diametro_prod) = $userinfo;
			  # echo "<pre>"; print_r(); echo "</pre>";
			   if($cod_prod == $cod_prod_get){
			   	$feedback['fretes'] = array();
				  // 	echo $peso_prod .' '.$comprimento_prod. ' '.$altura_prod. ' '.$diametro_prod. ' '  ;
					$servico = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=09146920&sDsSenha=123456&sCepOrigem=70002900&sCepDestino=71939360&nVlPeso=1&nCdFormato=1&nVlComprimento=30&nVlAltura=30&nVlLargura=30&sCdMaoPropria=n&nVlValorDeclarado=0&sCdAvisoRecebimento=n&nCdServico=40010,40045,40215,40290,41106&nVlDiametro=0&StrRetorno=xml&nIndicaCalculo=3";
				   	#echo "<br /><br /><br /><br />".$servico. "<br /><br /><br /><br /><br />";
				   	$servico = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=09146920&sDsSenha=123456&sCepOrigem=".$this->cep_origem."&sCepDestino=".$this->cep_destino."&nVlPeso=".$peso_prod."&nCdFormato=1&nVlComprimento=".$comprimento_prod."&nVlAltura=".$altura_prod."&nVlLargura=".$largura_prod."&sCdMaoPropria=n&nVlValorDeclarado=0&sCdAvisoRecebimento=n&nCdServico=40010,40045,40215,40290,41106&nVlDiametro=". $diametro_prod."&StrRetorno=xml&nIndicaCalculo=3";
				   	#echo "<br /><br /><br /><br /><br />".$servico . "<br /><br /><br /><br /><br /><br />";

				   	$xml = simplexml_load_file($servico);
					foreach ($xml->cServico as $key=>$v) {
						if($v->Valor != '0,00'){
							$feedback['fretes'][$key]['nome_frete'] =$this->converteServico($v->Codigo);
							$feedback['fretes'][$key]['prazo'] = $v->PrazoEntrega;
							$feedback['fretes'][$key]['valor'] = $v->Valor;
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