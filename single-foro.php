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

								
									$video = get_post_meta($post->ID, 'video-id', true); ?>
									<iframe width="450" height="320" src="http://www.youtube.com/embed/<?php echo $video?>" frameborder="0" allowfullscreen></iframe>

									<div id="platica"> <?php echo get_post_meta($post->ID, 'talk-name', true); ?> </div>
									
									<div id="foro"> FORO: <?php echo get_post_meta($post->ID, 'foro', true); ?> </div>	
						  				
									<?php the_content(); ?>
									<div id="biografía"> 
										<label>BIOGRAFÍA:</label> 
										<p><?php echo get_post_meta($post->ID, 'biografía', true); ?> </p>
									</div>
	 					  

						</div>
						<div id="me-gusta">
							<div id="facebook"><iframe  src="//www.facebook.com/plugins/like.php?href=<?php echo urlencode(get_permalink($post->ID)); ?>&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:21px;" allowTransparency="true"></iframe></div>
							<div id="google-mas"><g:plusone size="small" href="<?php echo urlencode(get_permalink($post->ID)); ?>"></g:plusone></div>
						</div>	
					</div>
			<?php endwhile; // end of the loop. ?>

			
					<div id="ponentes">
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
		
		