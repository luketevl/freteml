<?php
	require_once('includes/head.php');
?>
	<body>

	<section id='content' style="{possui_parametros}">

		<hgroup class="bs-callout bs-callout-info" id="servicoInfo">
			<h4> Cálculo do Frete </h4>
			<h5>O cálculo do frete é feito diretamente com os correios.</h5>
		 </hgroup>
		 <hgroup class="bs-callout bs-callout-danger" id="servicoErro" style="display:none;">
		     <h4>Serviço Indisponível</h4>
			 <h5>No momento não é possível carregar o frete deste produto.</h5>
		 </hgroup>

		<section id="erros">
			
		</section>
		<button type="button" class="btn btn-default" id='btnTentarNovamente'>Tentar Novamente</button>	
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

</section>

	<hgroup class="bs-callout bs-callout-danger" id="servicoError" style='{possui_parametros_mostra}'>
			<h4> Cálculo do Frete </h4>
			<h5>{possui_parametros_msg}.</h5>
		 </hgroup>

	</body>
</html>