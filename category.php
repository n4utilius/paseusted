<?php get_header(); ?>		
	<?php  get_sidebar(); ?>	

		<section id="contenido">
			<div id="seccion-post">
				<label> <?php echo $current_category = single_cat_title("", false);?> </label> 
				<div> </div>
			</div>
			<ul class="previews"> 
				<?php query_posts(  array( 'category_name' => $current_category , 
										    'paged' => get_query_var('page'), 
										    'posts_per_page'=>9 )              );?>
		
				<?php get_template_part('preview_items_tpl'); ?>
			</ul>
		</section>
<?php get_footer(); ?>			