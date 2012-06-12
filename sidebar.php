	<aside>
			<p class="about">
				Pase Usted es una organización sin fines de lucro comprometida 
				a difundir ideas y propuestas abiertas a una discusión plural 
				e incluyente entorno a los temas más relevantes de la agenda 
				actual de este país.
			</p>
			
			<ul class="tags">
			<?php $terms = get_terms('tags'); ?>
				<li id="top-tags"></li>
				<li id="tag-tags" class="tag-item"></li>
				
				<?php 
					$tags = array( "arte", "ciudad", "civismo", "cultura",
								   "diseno", "educacion", "medio-ambiente",
								   "politica", "salud", "tecnologia", "transporte");



					for ($i=0; $i<11 ; $i++) {
						echo '<li id="tag-' . $tags[$i] . '" class="tag-item"> 
					          	<a href="'.get_term_link($tags[$i], 'tags-pu').'">'. $tags[$i] . '</a>
							  </li>';
					} //'. get_term_link($tags[$i], 'tags_pu') . '
				?>
				<li id="buttom-tags"></li>
			</ul>

			<ul class="categorias">
				<?php
				    $analisis_link = get_term_link( 'analisis', 'categorias');
				    $propuesta_link = get_term_link( 'propuesta', 'categorias' );
				    $proyecto_link = get_term_link( 'proyecto', 'categorias' );

				 	
					function get_cat_title($cat){	
						$the_query = new WP_Query(  array( 'categorias' => $cat, 'posts_per_page' => 1 )  );
						while ( $the_query->have_posts() ) : $the_query->the_post();
							echo '<p class="titular">' . the_title() . '</p>';
							echo '<a id="mas" href="';  the_permalink();  echo '" >Más >> </a>';
						endwhile;
						wp_reset_postdata();
					}
				?>

				<li id="analisis"> 
					<div class="icon gray_icon"> <a href="<?php echo esc_url( $analisis_link ); ?>" title="Análisis" class="link-categoria">analisis</a> </div> 
					<?php get_cat_title('analisis') ?>	
				</li>
				<li id="propuesta">
					<div class="icon gray_icon"> <a href="<?php echo esc_url( $propuesta_link ); ?>" title="Propuesta" class="link-categoria">analisis</a> </div> 
					<?php get_cat_title('propuesta') ?>
				</li>
				<li id="proyecto"> 
					<div class="icon gray_icon"> <a href="<?php echo esc_url( $proyecto_link ); ?>" title="Proyecto" class="link-categoria">analisis</a> </div> 
					<?php get_cat_title('proyecto') ?>
				</li>
			</ul>
			<div class="twitter">	
				<script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script>
				<script>
					new TWTR.Widget({
					  version: 2,
					  type: 'profile',
					  rpp: 3,
					  interval: 30000,
					  width: 180,
					  height: 500,
					  theme: {
					    shell: {
					      background: '#fff',
					      color: '#6b516b'
					    },
					    tweets: {
					      background: '#fff',
					      color: '#050505',
					      links: '#80827f'
					    }
					  },
					  features: {
					    scrollbar: false,
					    loop: false,
					    live: true,
					    behavior: 'all'
					  }
					}).render().setUser('paseusted').start();
				</script>
			</div>
	</aside>
