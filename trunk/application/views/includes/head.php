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

	    <script src="<?php echo base_url()?>resources/js/jquery.maskedinput.js" type="text/javascript"></script>

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="<?php echo base_url()?>resources/css/bootstrap.min.css">

		<link rel="stylesheet" href="<?php echo base_url()?>resources/css/doc.css">

		<!-- Optional theme -->
		<link rel="stylesheet" href="<?php echo base_url()?>resources/css/bootstrap-theme.min.css">

		<link rel="stylesheet" href="<?php echo base_url()?>resources/css/normalize.css">
		<!-- 
		Latest compiled and minified JavaScript -->
		<script src="<?php echo base_url()?>resources/js/bootstrap.min.js"></script>

		<script src="<?php echo base_url()?>resources/js/funcoes.js"></script>

<script>
		$(document).ready(function(){
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
					$('btnTentarNovamente').show();
			  	}
			  	else{
			  		$('btnTentarNovamente').hide();
			  		$('#carrega').show();
				  	$('#carrega').html(msg);	
			  	}
			    
		});
    }
    else{
    	$('#grupoCep').addClass('has-error');
    	$('#cep').focus();
    }
});
		});
</script>
	</head>
