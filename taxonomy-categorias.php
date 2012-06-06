<?php/*Template Name: Categorias */?>

<?php get_header(); ?>		
	<?php  get_sidebar(); ?>	
		<section id="contenido">
			<div id="seccion-post">
				<label>	<?php echo $current_section = single_tag_title( '', false ); ?> </label> 
				<div> </div>
			</div>
			<ul class="previews"> 
				<?php $postCount = 0;?>
				<?php query_posts( array( 'categorias' => $current_section, 
										  'paged' => get_query_var('page'), 
										  'posts_per_page'=>9) 				);?>
				
				<?php get_template_part('preview_items_tpl'); ?>
			</ul>
		</section>	
<?php get_footer(); ?>	