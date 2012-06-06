<?php
/*Template Name: Search*/
?>
<?php get_header(); ?>		
	<?php  get_sidebar(); ?>	
		<section id="contenido">
			<?php $concept = $_REQUEST["concept"];?>
			<div id="seccion-post">
				<label>	Búsqueda de <?php echo $concept; ?> </label> 
				<div> </div>
			</div>
			<ul class="previews"> 
				<?php  $query_string = 'tag=' . $concept;
				       query_posts($query_string); 
					   get_template_part('preview_items_tpl'); ?>
			</ul>
		</section>
<?php get_footer(); ?>			