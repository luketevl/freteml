<?php
	require_once('includes/head.php');
?>

<section style="float:left;width:100%;">
	
	<blockquote class="bs-callout bs-callout-warning">
	    <h4>Dica</h4>
	    <p>Para inserir a lista dos seus produtos siga o passo a passo abaixo.</p>
	</blockquote>

	<blockquote class="bs-callout bs-callout-warning">
	    <h4>Passo a Passo</h4>
	    <ol>
		    <li> Baixe o arquivo para saber qual o formato correto. <a href="<?php echo base_url()?>resources/txt/padrao.txt" data-toggle="tooltip" data-placement="top" data-original-title="Clique para baixar" target="window"> <span class="glyphicon glyphicon-download" target="_blank"></span> </a>
		    </li>
		    
		    <li> Verifique se o conteúdo do seu arquivo esta na ordem certa.
		    </li>
		    
		    <li> Salve o arquivo no <strong>excel</strong> com a opção <code>CSV (separado por <strong>vírgulas</strong>)</code> 
		    </li>
		    
		    <li> Insira arquivos no formato <abbr title="O CSV é um implementação particular de arquivos de texto separados por um delimitador" ><code>CSV</code></abbr>
		    </li>
		    <li> Clique no botão abaixo para inserir o arquivo.
		    </li>
	    </ol> 
	</blockquote>
	<form class="form-horizontal" role="form" id="form-upload" method="POST" enctype="multipart/form-data" >
		<div class="container-fluid">
		        <div class="navbar-header">
		          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-3">
		          </button>
		          <a class="navbar-brand text-warning" href="#">Local do Arquivo</a>
		        </div>
			         <input type="file" style="left: -247.5px; top: 0px;" title="<span class='glyphicon glyphicon-plus'></span> Escolher Arquivo" accept="csv" id="file-csv" />
		      </div>
	 </form>

	<blockquote class="bs-callout bs-callout-warning">
	    <h4>Seus Arquivos</h4>
	    <p>

	    Você tem <span class="badge" id="qtd_arquivos">{qtd_arquivos}</span> arquivo(s) em sua pasta

 <div class="btn-group">
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
      Ações
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" id="opcoes_arquivo">
      <li><a href="<?php echo base_url();?>files/<?php echo $this->session->userdata('id_ent');?>/{nome_arquivo}" target="window">Ver Arquivo</a></li>
      <li><a href="<?php echo base_url();?>files/<?php echo $this->session->userdata('id_ent');?>/{nome_arquivo}" target="window">Baixar Arquivo</a></li>
      <li "{disabled_listar}" ><a href="?listar_produtos=1">Listar Produtos</a></li>
      <li><a href="" data-toggle="modal" data-target="#myModal">Copiar Calculadora</a></li>
    </ul>
	    </p>
	</blockquote>
</section>
<div class="table-responsive">
  <table class="table table-striped">
    <thead>
    	<tr>
	    	<th>Código</th>
	    	<th>Descrição</th>
	    	<th>Peso</th>
	    	<th>Comprimento</th>
	    	<th>Altura</th>
	    	<th>Largura</th>
	    	<th>Diametro</th>
	    	<th>Calculadora</th>
	    	<th>Ver Frete</th>
    	</tr>
    </thead>
    <tbody>
	    {linhas}
	    	<tr>
	    		<td>{cod}</td>
	    		<td>{desc}</td>
	    		<td>{peso}</td>
	    		<td>{comprimento}</td>
	    		<td>{altura}</td>
	    		<td>{largura}</td>
	    		<td>{diametro}</td>
		    	<td>
		    <button type="button" class="btn btn-default popover-dismiss" data-placement="left" data-toggle="popover" title="Copie o HTML abaixo para ter a calculadora" data-content="<a href='{calculadora}' target= '_blank' > <img src='<?php echo base_url()?>resources/img/banner-frete.jpg ' /> </a>"><span class="glyphicon glyphicon-link"></span> Gerar</button>
		    	<td><a href="{calculadora}" title="{calculadora}" target='_blank'><span class="glyphicon glyphicon-usd"></span> Frete</a> </td>
	    	</tr>
	    {/linhas}
    </tbody>
  </table>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
        <h4 class="modal-title" id="myModalLabel">Calculadora para o Frete</h4>
      </div>
      <div class="modal-body">
        <center>{link_calculadora}</center>
        <hr />
        <h4>Copie o código abaixo para utilizar a calculador em outros sites.</h4>
        <p>{link_calculadora_copia}<p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
	<?php
	require_once('includes/footer.php');
?>