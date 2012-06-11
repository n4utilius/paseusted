<!DOCTYPE HTML>
<html lang="es-ES">
<head>
	<meta charset="UTF-8">
	<title>
		<?php
			
			global $page, $paged;

			wp_title( '|', true, 'right' );

			bloginfo('name');

			$site_description = get_bloginfo( 'description', 'display' );

			if ( $site_description && ( is_home() || is_front_page() ) )
				echo " | $site_description";

		?>
	</title>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="screen" />

</head>

<body>
	<div id="wraper">
		<header>
			<a href="<?php bloginfo('url'); ?>"> <div class="logo"></div> </a>
			<div id="dock">
				<div class="contacto" >
					<form class="subscribir" >
						<label>Registrate y se parte de la comunidad de Pase Usted</label>
						<input type="submit" value="Enviar >>" />
						<input type="text" placeholder="e-mail" name="email" id="in-email"/>
						<div id='r-email'> </div>
					</form>

					<div class="social">
						<label>Síguenos</label>
						<a href="https://www.facebook.com/paseusted.org" id="facebook">facebook</a>
						<a href="https://twitter.com/paseusted" id="twitter">twitter</a>
					</div>
				</div>
				<div class="lang">
						<?php echo qtrans_generateLanguageSelectCode('both'); ?>
				</div>
			</div>
			<nav class="normal_nav">
				
				<?php $terms = get_terms('secciones'); ?>
				<ul class="menu">

					<?php 
						$secciones = array("foros", "genera", "tv", "radio", "ugp", "blog", "acerca");
						for ($i=0; $i<7 ; $i++) {
							echo '<li id="menu-' . $secciones[$i] . '"> 
									<a href="' . get_term_link($secciones[$i], 'secciones') . '">' . $secciones[$i] . '</a> 
								  </li>';
						}
					?>
				</ul>

				<?php get_search_form(); ?>

				<!--form id="searchform" method="get" action="<?php bloginfo('url'); ?>/search">
					<input type="text"  placeholder="Búsqueda" name="concept" id="concept" />
					<input type="submit"  value="" />
				</form-->
				
			</nav>	
		</header>