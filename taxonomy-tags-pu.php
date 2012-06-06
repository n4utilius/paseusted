<?php/*Template Name: Tags-PU*/?>

<?php get_header(); ?>		
	<?php  get_sidebar(); ?>	
		<section id="contenido">
			<div id="seccion-post">
				<label>	<?php echo $current_tag = single_tag_title( '', false ); ?> </label> 
				<div> </div>
			</div>
			<ul class="previews"> 
				<?php query_posts( array('tags-pu' => $current_tag , 
										 'paged' => get_query_var('page'), 
										 'posts_per_page'=>9 )              ); ?>

			<?php get_template_part('preview_items_tpl'); ?>

			</ul>
		</section>	
<?php get_footer(); ?>	