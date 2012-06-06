<?php get_header(); ?>		
	<?php  get_sidebar(); ?>	
		<section id="contenido">
			<div id="banner"></div>
			<div id="slider">
				<div id="example">
					<div id="slides">
						<div class="slides_container">

						<?php query_posts( array( 'posts_per_page'=>3 ) ); ?>
						<?php if (have_posts() ) : while ( have_posts() ) : the_post(); ?>  
							<div class="slide">
								<a href="<?php the_permalink(); ?>"> 
									<?php echo (has_post_thumbnail())? the_post_thumbnail('banner') : '';?>
								</a>
								<div class="capa-trans">
									<div class="post">
										<div class="titulo"><a href="<?php the_permalink(); ?>"> <?php the_title(); ?></a> </div>
										<p class="texto">
											<?php the_excerpt(); ?>
										</p>								
									</div>
									<div class="info">

										<?php $terms = get_the_terms( $post->ID, 'tags-pu' );					
											$tags_array = array();
											if ( $terms && ! is_wp_error( $terms ) ) {
												foreach ( $terms as $term ) { $tags_array[] = $term->name;}
												$tag = join( "-", $tags_array ); 							  ?>

												<img class="tag" src="<?php bloginfo('template_url');?>/images/tag-<?php echo $tag; ?>.gif" />
									  <?php } ?>
										<a class="link" href="<?php the_permalink() ?>">Más >></a>
									</div>
								</div>
							</div>
						<?php endwhile; else: ?> 
			    			<h2>Not Found</h2>
			 				<div class="entrybody"> Disculpa, pero estás buscando algo que no esta aquí. </div>
		 				<?php endif; ?> 
						</div>
						<a href="" class="prev"><img src="<?php bloginfo('template_url');?>/images/arrow-prev.png" width="24" height="43" ></a>
						<a href="" class="next"><img src="<?php bloginfo('template_url');?>/images/arrow-next.png" width="24" height="43" ></a>
					</div>
				</div>
			</div>
			<ul class="previews"> 
			<?php query_posts( array( 'posts_per_page'=>9 ) ); ?>
		
			<?php get_template_part('preview_items_tpl'); ?>

		</section>
<?php get_footer(); ?>			