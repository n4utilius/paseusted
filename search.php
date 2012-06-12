<?php
/*Template Name: Search*/
?>
<?php get_header(); ?>		
	<?php  get_sidebar(); ?>	
		<section id="contenido">
			<?php $concept = $_REQUEST["s"];?>
			<div id="seccion-post">
				<label>	Búsqueda de <?php echo get_search_query() ?> </label> 
				<div> </div>
			</div>
			<ul class="previews"> 
				<?php  
					get_template_part('preview_items_tpl'); 
				?>
			</ul>
		</section>
<?php get_footer(); ?>			