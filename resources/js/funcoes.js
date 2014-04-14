$(document).ready(function(){
	$('a').tooltip();
	/*
	$('#file-csv').MultiFile({
		afterFileAppend: function(element, value, master_element){ 
			alert('Apeend');
			 $.ajax({
	          type: "POST",
	          url: "upload/upload_arquivo",
	          data: $('form-csv').serialize()
	        })
	          .success(function( msg ) {
          		var n = noty({text: msg, type: 'error'});

	          });
			
		}
	});
*/

$("#file-csv").uploadFile({
	url:"upload/upload_arquivo",
	fileName:"myfile",
	 dragDrop: true,
	 returnType: "json",
	 showDelete: true,
	 onSuccess : function (){
	 	var n = noty({text: 'Arquivo selecionado, aguarde montando dados.', type: 'success', shadow: false, styling: "bootstrap" , hide: true, delay: 500,
			killer: true
        });
		setInterval(function(){
		 	location.reload();
			},3000);
	 },
	 deleteCallback: function (data, pd) {
     for (var i = 0; i < data.length; i++) {
         $.post("delete.php", {op: "delete",name: data[i]},
             function (resp,textStatus, jqXHR) {
                 //Show Message	
                 alert("Arquivo Deletado");
             });
     }
	     pd.statusbar.hide(); //You choice.
}
	});


	$(":file").bootstrapFileInput();
	$('#cep').mask('99999-999');

	$('#btnTentarNovamente').hide();

	$('#btnTentarNovamente').click(function(){
		location.reload();
	});
	$('#cep').keypress(function(){
		$('#grupoCep').removeClass('has-error');
		$('#carrega').hide();
	});

if($('#qtd_arquivos').text() <= 0){
	$('#opcoes_arquivo > li').each(function(){
		$(this).addClass('disabled');
	});
}

$('#listar_arquivos').click(function(){
	redirect('?listar_produtos=1');
});


	});
