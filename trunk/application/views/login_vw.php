<?php
	require_once('includes/head.php');
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('a').tooltip();
		$('#login').hide();
		$('#cadastrar').hide();
		$('a#openLogin').click(function(){
			$('#login').show(600);
			$('#cadastrar').hide(500);
		});
		$('a#openCadastro').click(function(){
			$('#cadastrar').show(600);
			$('#login').hide(500);
		});

/*
		$("#login").validate({
			submitHandler: function(form){
			var formulario = $('form#login');
			var dados = formulario.serialize();
			 $.ajax({
		          type: "POST",
		          url: "acesso/cadastrar",
		          data: dados
		        })
		          .success(function( msg ) {
		        	var n = noty({text: msg, type: 'error'});
		          });
				return false;
			}
		});
*/

		$('input[name="email"]').keypress(function(){
			//$(this).parent('#group-email');
			//console.log($(this).parent('#group-email'));
			console.log(this);
			var elemento = $(this).parents('.form-group');
			console.log(elemento);
			$(elemento).removeClass('has-error');
		});


		$('#login').submit(function(event){
			var formulario = $('form#login');
			var dados = formulario.serialize();
	        $.ajax({
	          type: "POST",
	          url: "acesso/logar",
	          data: dados
	        })
	          .success(function( msg ) {
          		var n = noty({text: msg, type: 'error'});

	          });
	          event.preventDefault;
        	  return false;
			});

		$('#cadastrar').submit(function(event){
			var formulario = $('form#cadastrar');
			var dados = formulario.serialize();
	        $.ajax({
	          type: "POST",
	          url: "acesso/cadastrar",
	          data: dados
	        })
	          .success(function( msg ) {
	          	var obj = jQuery.parseJSON(msg);
	          	if(obj.cod == '-1'){
		        	var n = noty({text: obj.msg, type: 'error'});
		        	$('#group-email').addClass('has-error');
		        	$('#group-email > input[name="email"]').focus();
	          	}
	          	else if(obj.cod == '1'){
	          		var n = noty({text: obj.msg, type: 'success'});
	          		setInterval(function(){window.location ='upload';},3000);
	          	}
	          });
			  event.preventDefault;
        	  return false;
			});

	});

</script>
	<body>
	<hgroup class="bs-callout bs-callout-info">
	<h4> Entrar </h4>
	<h5>Caso já possua cadastro em nosso site, <a href="#" id="openLogin">clique aqui</a> para entrar.</h5>
 

		<form class="form-horizontal" role="form" id="login" method="POST">
			<div class="form-group" id="group-email-login">
				<div class="input-group">
				  <span class="input-group-addon">
					  <img src="resources/img/email.png" width="14px" height="14px" />
				  </span>
				  <input type="email" class="form-control" placeholder="Email" name="email" required>
				</div>
			</div>

			<div class="form-group">
				<div class="input-group">
				  <span class="input-group-addon">
				  	<img src="resources/img/lock.png" width="14px" height="14px" />
				  </span>
				  <input type="password" class="form-control" placeholder="Senha" name="senha" required>
				</div>
			</div>
			<div class="form-group">
		      <button type="submit" class="btn btn-default" id="btnEntrar">Entrar</button>
		    </div>
		</form>
	</hgroup>

 <hgroup class="bs-callout bs-callout-info">
	<h4> Cadastrar </h4>
	<h5><a href="#" id="openCadastro"  data-toggle="tooltip" data-placement="bottom" data-original-title="Vamos lá, é rápido e fácil!!">Clique aqui</a> para se cadastrar em nosso site e ter acesso aos nossos recursos</h5>

		<form class="form-horizontal" role="form" id="cadastrar" method="POST">
			<div class="form-group">
				<div class="input-group">
				  <span class="input-group-addon">
				  	<span class="glyphicon glyphicon-user"></span>
				  </span>
				  <input type="text" class="form-control" placeholder="Nome" name="nome" required>
				</div>
			</div>

			<div class="form-group" id="group-email">
				<div class="input-group">
				  <span class="input-group-addon">
				  	<img src="resources/img/email.png" width="14px" height="14px" />
				  </span>
				  <input type="email" class="form-control" placeholder="Email" name="email" required>
				</div>
			</div>

			<div class="form-group">
				<div class="input-group">
				  <span class="input-group-addon">
				  	<img src="resources/img/lock.png" width="14px" height="14px" />
				  </span>
				  <input type="password" class="form-control" placeholder="Senha" name="senha" required>
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
				  <span class="input-group-addon">
				  	<img src="resources/img/lock.png" width="14px" height="14px" />
				  </span>
				  <input type="password" class="form-control" placeholder="Confirmar senha" name="senha" required>
				</div>
			</div>
			<div class="form-group">
		      <button type="submit" class="btn btn-default" id="btnCadastrar" >Cadastrar</button>
		    </div>
		</form>
</hgroup>
	</body>
</html>