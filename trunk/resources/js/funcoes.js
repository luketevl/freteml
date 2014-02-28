$(document).ready(function(){
	$('#cep').mask('99999-999');
	$('#erros').hide();
	$('#btnTentarNovamente').hide();

	$('#btnTentarNovamente').click(function(){
		location.reload();
	});
	$('#cep').keypress(function(){
		$('#grupoCep').removeClass('has-error');
		$('#carrega').hide();
	});
	});
