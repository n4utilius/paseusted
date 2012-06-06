<?php /* Template Name: encabezado_post_tpl */?>
				<div id="seccion-post">
					<label>
						<?php 
							$terms = get_the_terms( $post->ID, 'categorias' );
							foreach ( $terms as $term ) { $categoria_array[] = $term->name;}
							echo $categoria = join( "-", $categoria_array ); 
						?>
					</label> 
					<div> </div>
				</div>

					<div id="titulo-compartir">
						<div id="marco">
							<label id="titulo"> <?php wp_title(); ?> </label>

							<div id="compartir">
								<label>Compartir</label>
								<a href="http://twitter.com/home?status=<?php echo "Leyendo " . wp_title() . urlencode(get_permalink($post->ID)) . " vía @paseusted";?>">
									<img src="<?php bloginfo('template_url');?>/images/twitter-icon.gif">
								</a>
								<a target="_blank" href="http://www.facebook.com/sharer.php?u=<?php echo urlencode(get_permalink($post->ID)); ?>">
									<img src="<?php bloginfo('template_url');?>/images/facebook-icon.gif"> 
								</a>
							</div>	

							<?php $terms = get_the_terms( $post->ID, 'tags-pu' );					
								if ( $terms && ! is_wp_error( $terms ) ) {
									foreach ( $terms as $term ) { $tags_array[] = $term->name;}
									$tag = join( "-", $tags_array ); 
							?>
								<img id="tag" src="<?php bloginfo('template_url');?>/images/tag-<?php echo $tag; ?>.gif" />
							<?php } ?>

							<img id="categoria" src="<?php bloginfo('template_url');?>/images/icon-<?php echo $categoria;?>.png">
							
						</div>
					</div>