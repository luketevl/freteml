<?php
	require_once('includes/head.php');
?>
<script type="text/javascript">
	$(document).ready(function(){
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

		$('#btnEntrar').click(function(){
	        var formulario = $('#login');
			var dados = formulario.serialize();
			console.log(dados);
	        $.ajax({
	          type: "GET",
	          url: "acesso/logar",
	          data: dados
	        })
	          .success(function( msg ) {
	          });

			});

	});

</script>
	<body>
	<hgroup class="bs-callout bs-callout-info">
	<h4> Entrar </h4>
	<h5>Caso já possua cadastro em nosso site, <a href="#" id="openLogin">clique aqui</a> para entrar.</h5>
 

		<form class="form-horizontal" role="form" id="login" method="post">
			<div class="form-group">
				<div class="input-group">
				  <span class="input-group-addon">
					  <img src="resources/img/email.png" width="14px" height="14px" />
				  </span>
				  <input type="email" class="form-control" placeholder="Email">
				</div>
			</div>

			<div class="form-group">
				<div class="input-group">
				  <span class="input-group-addon">
				  	<img src="resources/img/lock.png" width="14px" height="14px" />
				  </span>
				  <input type="password" class="form-control" placeholder="Senha">
				</div>
			</div>
			<div class="form-group">
		      <button type="button" class="btn btn-default" id="btnEntrar">Entrar</button>
		    </div>
		</form>
	</hgroup>

 <hgroup class="bs-callout bs-callout-info">
	<h4> Cadastrar </h4>
	<h5><a href="#" id="openCadastro">Clique aqui</a> para se cadastrar em nosso site e ter acesso aos nossos recursos</h5>

		<form class="form-horizontal" role="form" id="cadastrar">
			<div class="form-group">
				<div class="input-group">
				  <span class="input-group-addon">
				  	<span class="glyphicon glyphicon-user"></span>
				  </span>
				  <input type="text" class="form-control" placeholder="Nome">
				</div>
			</div>

			<div class="form-group">
				<div class="input-group">
				  <span class="input-group-addon">
				  	<img src="resources/img/email.png" width="14px" height="14px" />
				  </span>
				  <input type="email" class="form-control" placeholder="Email">
				</div>
			</div>

			<div class="form-group">
				<div class="input-group">
				  <span class="input-group-addon">
				  	<img src="resources/img/lock.png" width="14px" height="14px" />
				  </span>
				  <input type="password" class="form-control" placeholder="Senha">
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
				  <span class="input-group-addon">
				  	<img src="resources/img/lock.png" width="14px" height="14px" />
				  </span>
				  <input type="password" class="form-control" placeholder="Confirmar senha">
				</div>
			</div>
			<div class="form-group">
		      <button type="button" class="btn btn-default">Cadastrar</button>
		    </div>
		</form>
</hgroup>
	</body>
</html>