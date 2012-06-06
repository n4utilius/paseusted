<?php /* Template Name: contenido_relacionado_tpl */?>

				<div id="encabezado_relacionado"> CONTENIDO RELACIONADO </div>
					<ul id="post-relacionados">
						<?php
							//para poner en el loop, muestra 5 titulos de post relacionados con la primera tag del post actual
							global $post;
							$terms = get_the_terms( $post->ID , 'tags-pu', 'string');
							$do_not_duplicate[] = $post->ID;
								 
							if(!empty($terms)){
							   foreach ($terms as $term) {
							      query_posts( array('tags-pu' => $term->slug,
							                         'showposts' => 4,
							                         'caller_get_posts' => 1,
								                     'post__not_in' => $do_not_duplicate ) );
							      
							      if(have_posts()){
							         while ( have_posts() ) : the_post(); $do_not_duplicate[] = $post->ID; ?>
							        	
										<li>
											<?php 
												if ( has_post_thumbnail() ){
													the_post_thumbnail('releated');
												}else{echo 'eco';}
											?>
											
											<div class="icons">
												<?php foreach((get_the_category()) as $category) {  
													if($category->cat_name != "Sin categoría"){  ?>
														<img class="categoria" src="<?php bloginfo('template_url');?>/images/icon-<?php echo $category->cat_name;?>.png">
											  <?php }
												} ?>
												
												<?php $terms = get_the_terms( $post->ID, 'secciones' );					
													if ( $terms && ! is_wp_error( $terms ) ) {
													$seccion_array = array();
													foreach ( $terms as $term ) { $seccion_array[] = $term->name;}
													$seccion = join( "-", $seccion_array ); 
												?>
													<img class="seccion" src="<?php bloginfo('template_url');?>/images/icon-<?php echo $seccion; ?>.png" />
												<?php } ?>
											</div>

											<div class="post">
												<div ><?php the_title();?></div>
												<p> <?php the_excerpt(); ?> </p>
											</div>
											
											<?php $terms = get_the_terms( $post->ID, 'tags-pu' );					
												if ( $terms && ! is_wp_error( $terms ) ) {
													$tags_array = array();
													foreach ( $terms as $term ) { $tags_array[] = $term->name;}
													$tag = join( "-", $tags_array ); 
											?>
												<img class="post-tag" src="<?php bloginfo('template_url');?>/images/tag-<?php echo $tag; ?>.gif" />
											<?php } ?>

											<div class="mas">
												<a class="comentarios" href="#"> <?php comments_popup_link();?> </a>
												<a class="link" href="<?php the_permalink() ?>">Más >></a>
											</div>
										</li>
							         <?php endwhile; wp_reset_query();
							      }
							   }
							}
						?>

						
					</ul>