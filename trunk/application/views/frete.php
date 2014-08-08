<?php
	require_once('includes/head.php');
?>
	<body>

	<hgroup class="bs-callout bs-callout-danger" id="servicoError" style='{possui_parametros_mostra}'>
			<h4> Cálculo do Frete </h4>
			<h5>{possui_parametros_msg}.</h5>
		 </hgroup>

	<section id='content' style="{possui_parametros}">

		<hgroup class="bs-callout bs-callout-warning" id="servicoInfo">
			<h4> Cálculo do Frete </h4>
			<h5>O cálculo do frete é feito diretamente com os correios.</h5>
		 </hgroup>
		 <hgroup class="bs-callout bs-callout-danger" id="servicoErro" style="display:none;">
		     <h4>Serviço Indisponível</h4>Generated HTML markup for suggestions is displayed bellow. You may style it any way you'd like.
			 <h5>No momento não é possível carregar o frete deste produto.</h5>
		 </hgroup>

		<section id="erros">
			
		</section>
		<button type="button" class="btn btn-default" id='btnTentarNovamente'>Tentar Novamente</button>	
 		<form class="form-horizontal" role="form" id="lerArquivo" method="GET" action="lerArquivo">
			 <div class="col-lg-3" id="camposFrete">
			 <input type="hidden" name="cod_cli" value="<?php echo $_GET['cod_cli'];?>" />
			 <input type="hidden" name="cod_prod" value="<?php echo $_GET['cod_prod'];?>" />
		    	<div class="input-group"  id="grupoCep">
			  	<span class="input-group-addon">CEP</span>
			  	<input type="text" class="form-control" id="cep" name="cep" placeholder="00000-000" />
			  		<span class="input-group-btn">
			    		<button class="btn btn-default" id="calcularFrete" type="submit"><span class="glyphicon glyphicon-usd"></span> Calcular Frete </button>
		      		</span>
		    	</div>
			</div>
		</form>
	<section id="carrega" style="float:right;">

	</section>

</section>


			<div class="panel panel-warning" style="{exibe_fretes}; margin-top: 74px;">
    			<div class="panel-heading">
    				<h3 class="panel-title">Fretes Disponíveis</h3>
    			</div>
			{fretes}

			  <a href="#" class="list-group-item">
			    <h4 class="list-group-item-heading">{nome_frete}</h4>
			    <p class="list-group-item-text">R$ {valor}</p>
			    <p class="list-group-item-text">{prazo} dias</p>
			  </a>
			{/fretes}
			</div>
		
					<hgroup class="bs-callout bs-callout-error" id="servicoErro" style="{exibe_erros}">
					    <h4> Possíveis Problemas </h4>
	
					{erros}
				
						<h5>{msg}</h5>
				
						 {/erros}
					
					</hgroup>
					
		<hgroup class="bs-callout bs-callout-warning" id="indicarProduto" style="{erro_cliente}">
			<h4> Cálculo do Frete </h4>
			<h5>Para calcular o <code>frete</code> digite o <code>nome do produto</code> no campo abaixo</h5>
			<form class="form-horizontal" role="form" id="login" method="POST">
			<div class="form-group" id="group-email-login">
				<div class="input-group">
				  <span class="input-group-addon">
					<span class="glyphicon glyphicon-search"></span>
				  </span>
				  				  <input type="text" class="form-control" placeholder="Digite o NOME do produto" name="country" required id="autocomplete-dynamic" >
				</div>
			</div>
		</form>
		 </hgroup>
					
<?php
	require_once('includes/footer.php');
?>