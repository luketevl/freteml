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
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	</head>
	<body>

 <hgroup class="bs-callout bs-callout-info">
		<h4> Cálculo do Frete </h4>
		 <h5>O cálculo do frete é feito diretamente com os correios.</h5>
 		 <h5>O cálculo do frete é feito diretamente com os correios.</h5>
 		 <h5>O cálculo do frete é feito diretamente com os correios.</h5>
 </hgroup>

 <div class="col-lg-3">
    <div class="input-group">
	  <input type="text" class="form-control" id='cep' name="cep" placeholder="00000-000" />
	  	<span class="input-group-btn">
	    	<button class="btn btn-default" type="button"><span class="glyphicon glyphicon-usd"></span> Calcular Frete</button>
      	</span>
    </div>
	</div>
	</body>
</html>

<?php

class FreteMl {

	private $arquivoNome = 'arquivo.txt';

	public function lerArquivo($cod_prod_get){
		$arquivo = $this->arquivoNome;
		if(file_exists('resources/txt/'.$arquivo)){
	        echo "arquivo existe";
			$handle = fopen('resources/txt/'.$arquivo, "r");
			while ($userinfo = fscanf($handle, "%s\t%s\t%s\t%s\t%s\t%s\t%s\n")) {
			 //  echo "<pre>"; print_r(list ($cod_prod, $nome_prod, $peso_prod, $comprimento_prod, $altura_prod, $diametro_prod) = $userinfo); echo "</pre>";
			   list ($cod_prod, $nome_prod, $peso_prod, $comprimento_prod, $altura_prod, $diametro_prod) = $userinfo;
			  # echo "<pre>"; print_r(); echo "</pre>";
			   if($cod_prod == $cod_prod_get){
				  // 	echo $peso_prod .' '.$comprimento_prod. ' '.$altura_prod. ' '.$diametro_prod. ' '  ;
					$servico = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=09146920&sDsSenha=123456&sCepOrigem=70002900&sCepDestino=71939360&nVlPeso=1&nCdFormato=1&nVlComprimento=30&nVlAltura=30&nVlLargura=30&sCdMaoPropria=n&nVlValorDeclarado=0&sCdAvisoRecebimento=n&nCdServico=40010,40045,40215,40290,41106&nVlDiametro=0&StrRetorno=xml&nIndicaCalculo=3";
				   	$xml = simplexml_load_file($servico);
					foreach ($xml->cServico as $v) {
						echo $v->Codigo;


					}
				   	 echo "<pre>"; print_r($xml); echo "</pre>";

				   	break;
			   }
			}
			fclose($handle);
		}
		else{
			echo "arquivo NAO existe";	
		}
	}

}
$a = new FreteMl();
$a->lerArquivo($_GET['cod_prod']);
