<?php /* Template Name: ponentes_carrucel_tpl */?>

					<div id="coletilla"></div>
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
					
						</ul>