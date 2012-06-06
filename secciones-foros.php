<?php get_header(); ?>		
	<?php  get_sidebar(); ?>	
		<section id="contenido">
			<div id="seccion-post">
				<label>	<?php echo $sec_name = single_tag_title( '', false );?> </label> 
				<div> </div>
			</div>
			<ul class="previews"> 
				<?php   query_posts( array( 'paged' => get_query_var('page'), 
						       				'posts_per_page'=>9, 
								    		'post_type'=>'foro'));          ?>
			
				<?php get_template_part('preview_items_tpl'); ?>
			</ul>
		</section>	
<?php get_footer(); ?>	