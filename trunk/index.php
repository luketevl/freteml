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

	    <script src="resources/js/jquery.maskedinput.js" type="text/javascript"></script>

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="resources/css/bootstrap.min.css">

		<link rel="stylesheet" href="resources/css/doc.css">

		<!-- Optional theme -->
		<link rel="stylesheet" href="resources/css/bootstrap-theme.min.css">

		<link rel="stylesheet" href="resources/css/normalize.css">
		<!-- 
		Latest compiled and minified JavaScript -->
		<script src="resources/js/bootstrap.min.js"></script>

		<script>
			$(document).ready(function(){
				$('#cep').mask('99999-999');
				$('#erros').hide();
				$("#calcularFrete").click(function(){
			    var cep_cli = $('#cep').val();
			    if(cep_cli.length == 9){
				    $.ajax({
						  type: "GET",
						  url: "FreteML.php",
						  data: { cep: cep_cli , cod_prod :  <?php echo $_GET['cod_prod'];?> }
						})
						  .success(function( msg ) {
						  	if(msg.indexOf('bs-callout-warning') != '-1'){
								$('#servicoInfo').hide();
								$('#camposFrete').hide();
								$('#servicoErro').show();
								$('#carrega').hide();
								$('#erros').show();
								$('#erros').html(msg);
						  	}
						  	else{
							  	$('#carrega').html(msg);	
						  	}
						    
					});
			    }
			    else{
			    	$('#grupoCep').addClass('has-error');
			    	$('#cep').focus();
			    }
			});
				$('#btnTentarNovamente').click(function(){
					location.reload();
				});
				$('#cep').keypress(function(){
					$('#grupoCep').removeClass('has-error');
				});
				});
		</script>
	</head>
	<body>
	<hgroup class="bs-callout bs-callout-info" id="servicoInfo">
		<h4> Cálculo do Frete </h4>
		<h5>O cálculo do frete é feito diretamente com os correios.</h5>
	 </hgroup>
	 <hgroup class="bs-callout bs-callout-danger" id="servicoErro" style="display:none;">
	     <h4> Serviço Indisponível </h4>
		 <h5>No momento não é possível carregar o frete deste produto.</h5>
		 <button type="button" class="btn btn-default" id='btnTentarNovamente'>Tentar Novamente</button>
	 </hgroup>
	<section id="erros"></section>
	 <div class="col-lg-3" id="camposFrete">
	    <div class="input-group"  id="grupoCep">
		  <span class="input-group-addon">CEP</span>
		  <input type="text" class="form-control" id="cep" name="cep" placeholder="00000-000" />
		  	<span class="input-group-btn">
		    	<button class="btn btn-default" id="calcularFrete" type="button"><span class="glyphicon glyphicon-usd"></span> Calcular Frete</button>
	      	</span>
	    </div>
	</div>
<section id="carrega" style="float:right;">

</section>
	</body>
</html>