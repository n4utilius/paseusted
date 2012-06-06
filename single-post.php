<?php get_header(); ?>		
	<?php  get_sidebar(); ?>	
		<section id="contenido"> 
			<?php while ( have_posts() ) : the_post(); ?>
				<div id="encabezado"> <!--Solo es un indicador de la seccion del doc-->
					<?php get_template_part('encabezado_post_tpl'); ?>
				</div>

				<div id="columna-izq">
					<div id="post">
						<div id="texto">
							<?php 
								$terms = get_the_terms( $post->ID, 'secciones' );					
								$seccion_array = array();
								if ( $terms && ! is_wp_error( $terms ) ) {
									foreach ( $terms as $term ) { $seccion_array[] = $term->name;}
									$seccion = join( "-", $seccion_array ); 
								}
							?>
							<?php the_content(); ?>

						</div>
						<div id="me-gusta">
							<div id="facebook"><iframe  src="//www.facebook.com/plugins/like.php?href=<?php echo urlencode(get_permalink($post->ID)); ?>&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:21px;" allowTransparency="true"></iframe></div>
							<div id="google-mas"><g:plusone size="small" href="<?php echo urlencode(get_permalink($post->ID)); ?>"></g:plusone></div>
						</div>	
					</div>
			<?php endwhile; // end of the loop. ?>

			
					<div id="ponentes">
						<!--div id="coletilla"></div>
							<div id="encabezado_ponentes"> PONENTES</div>

							<ul id="carrucel">
					
							<?php 
								$the_query = new WP_Query( array( 'post_type' => 'foro') );
								while ( $the_query->have_posts() ) : $the_query->the_post();
									echo '<li>';
									echo '  <a id="mas" href="';  the_permalink();  echo '" >';
									echo      (has_post_thumbnail())? the_post_thumbnail('carrucel') : '';
									echo '  </a>';
									echo '  <p>' . the_title() . '</p>';
									echo '</li> :trololol:';
								endwhile;
								wp_reset_postdata();
							?>			
						</ul-->
						<?php get_template_part('ponentes_carrucel_tpl'); ?>
					</div>
					<div id="comentarios">
						<div id="encabezado_comentarios"> COMENTARIOS </div>
						<?php comments_template(); ?>
					</div>
				</div>
				<div id="columna-der">
					<?php get_template_part('contenido_relacionado_tpl'); ?>
				</div>
		</section>
		<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
		

<?php get_footer(); ?>	
		
		