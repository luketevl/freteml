<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Responsive Retina-Friendly Menu with different, size-dependent layouts" />
	<meta name="keywords" content="responsive menu, retina-ready, icon font, media queries, css3, transition, mobile" />
	<meta name="author" content="Codrops" />
	<title>Bem Vindo - FlyMoto</title>
		
   <?php
		$this->load->view('includes/head');
   ?>

</head>
<body>


<header>
	<nav id="menu" class="nav">					
		<ul>
			<li>
				<a href="#" id="inicio">
					<span class="icon">
						<i aria-hidden="true" class="icon-home"></i>
					</span>
					<span>Inicio</span>
				</a>
			</li>
			<li>
				<a href="#">
				<?php
 					echo form_hidden('url','solicitar_motoboy');
				?>
					<span class="icon">
						<i aria-hidden="true" class="icon-portfolio"></i>
					</span>
					<span>Soliciar Motoboy</span>
				</a>
			</li>
			<li>
				<a href="#" id="opcoes">
				<?php
 					echo form_hidden('url','opcoes');
				?>
					<span class="icon">
						<i aria-hidden="true" class="icon-blog"></i>
					</span>
					<span>Configurações</span>
				</a>
			</li>
			<li>
				<a href="#">
					<span class="icon">
						<i aria-hidden="true" class="icon-regulamento"></i>
					</span>
					<span>Ajuda</span>
				</a>
			</li>
			<li>
				<a href="site/landing_page#cadastro">
					<span class="icon">
						<i aria-hidden="true" class="icon-contact"></i>
					</span>
					<span>Contato</span>
				</a>
			</li>
			<li>
				<a href="login_controller/deslogar">
				<?php

 				#	echo form_hidden('url','cadastros/entidades');
				?>
					<span class="icon"> 
						<i aria-hidden="true" class="icon-team"></i>
					</span>
					<span><?php echo $this->session->userdata('nome_ent'); ?></span>
				</a>
			</li>
		</ul>
	</nav>
</header>
<div id="camposEscondidos">
	<input type="hidden" name="latitude_cli_entra"  id="latitude_cli_entra" />
	<input type="hidden" name="longitude_cli_entra" id="longitude_cli_entra" />
	<?php 
	//	<input type="hidden" name="usa_sessao" id="longitude_cli_entra" />
	?>
</div>
<section id="centro">

<section id="sessao-json">
	<?php

		$this->load->view('localizacao_atual');
	?>
	<section id="troca">
		
	</section>

</section>


		<script>
				//  The function to change the class
				var changeClass = function (r,className1,className2) {
					var regex = new RegExp("(?:^|\\s+)" + className1 + "(?:\\s+|$)");
					if( regex.test(r.className) ) {
						r.className = r.className.replace(regex,' '+className2+' ');
				    }
				    else{
						r.className = r.className.replace(new RegExp("(?:^|\\s+)" + className2 + "(?:\\s+|$)"),' '+className1+' ');
				    }
				    return r.className;
				};	

				//  Creating our button in JS for smaller screens
				var menuElements = document.getElementById('menu');
				menuElements.insertAdjacentHTML('afterBegin','<button type="button" id="menutoggle" class="navtoogle" aria-hidden="true"><i aria-hidden="true" class="icon-menu"> </i> Menu</button>');

				//  Toggle the class on click to show / hide the menu
				document.getElementById('menutoggle').onclick = function() {
					changeClass(this, 'navtoogle active', 'navtoogle');
				}

				// http://tympanus.net/codrops/2013/05/08/responsive-retina-ready-menu/comment-page-2/#comment-438918
				document.onclick = function(e) {
					var mobileButton = document.getElementById('menutoggle'),
						buttonStyle =  mobileButton.currentStyle ? mobileButton.currentStyle.display : getComputedStyle(mobileButton, null).display;

					if(buttonStyle === 'block' && e.target !== mobileButton && new RegExp(' ' + 'active' + ' ').test(' ' + mobileButton.className + ' ')) {
						changeClass(mobileButton, 'navtoogle active', 'navtoogle');
					}
				}
			</script>
			