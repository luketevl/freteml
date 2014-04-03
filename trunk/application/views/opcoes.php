<?php
	require_once('includes/head.php');
?>
	<body>
		<hgroup class="bs-callout bs-callout-info" id="configInfo">
			<h4> Opções do sistema </h4>
			<h5>Para o correto funcionamento do sistema de frete é necessário a configuração dos itens abaixo, caso já tenha preenchido <a href="<?php echo base_url();?>upload">clique aqui</a>.</h5>
		 </hgroup>



<form class="form-horizontal" role="form" method="POST" action="<?php echo base_url()?>opcoes/save">
	<input type="hidden" name="id_opc" name="id_opc" value="{id_opc}"/>
  <div class="form-group">
    <label for="inputCep" class="col-sm-1 control-label">CEP</label>
    <div class="col-sm-3">
      <input type="text" class="form-control" id="cep" name="cep_origem" placeholder="00000-000" required value="{cep_origem}" />
    </div>
  </div>
 
  <div class="form-group">
    <div class="col-sm-offset-1 col-sm-10">
       <button type="submit" class="btn btn-default">Salvar</button>
   </div>
  </div>
</form>

	</body>
</html>