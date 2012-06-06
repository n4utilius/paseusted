<?php /* Template Name: preview_items */?>

			<?php if (have_posts() ) {
			 		while ( have_posts() ) : the_post(); ?>  
						<li> 
							<a href="<?php the_permalink(); ?>"> 
								<?php echo (has_post_thumbnail())? the_post_thumbnail('preview') : '';?>
							</a>

							<?php $terms = get_the_terms( $post->ID, 'tags-pu' );					
								if ( $terms && ! is_wp_error( $terms ) ) {
									$tags_array = array();
									foreach ( $terms as $term ) { $tags_array[] = $term->name;}
									$tag = join( "-", $tags_array ); 
							?>
								<img class="tags" src="<?php bloginfo('template_url');?>/images/tag-<?php echo $tag; ?>.gif" />
							<?php } ?>

							<div class="mas">
								<?php comments_popup_link();?>
								<a class="link" href="<?php the_permalink() ?>">Más >></a>
							</div>
							<div class="capa-trans">
								<p class="encabezado"> <a href="<?php the_permalink(); ?>"> <?php the_title(); ?></a> </p>
								<div class="icons">
								  
								<?php $terms = get_the_terms( $post->ID, 'categorias' );					
									if ( $terms && ! is_wp_error( $terms ) ) {
										$categoria_array = array();
										foreach ( $terms as $term ) { $categoria_array[] = $term->name;}
										$categoria = join( "-", $categoria_array ); 
								?>
										<img class="categoria" src="<?php bloginfo('template_url');?>/images/icon-<?php echo $categoria; ?>.png">
								<?php } ?>
									
									<?php $terms = get_the_terms( $post->ID, 'secciones' );					
										if ( $terms && ! is_wp_error( $terms ) ) {
										$seccion_array = array();
										foreach ( $terms as $term ) { $seccion_array[] = $term->name;}
										$seccion = join( "-", $seccion_array ); 
									?>
										<img class="seccion" src="<?php bloginfo('template_url');?>/images/icon-<?php echo $seccion; ?>.png" />
									<?php } ?>
										
							</div>
						</li>

				<?php endwhile; 

					}else{ echo "<label id='not-found'> Contenido no encontrado </label>";}
				?> 