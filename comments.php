
<?php if(comments_open()) : ?>
	<?php if(get_option('comment_registration') && !$user_ID) : ?>
		<p>Debes 
		<a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">
			registrarte
		</a> para publicar un comentario.</p><?php else : ?>
		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
		<?php if($user_ID) : ?>
			<p>   Conectado como <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?> </a>. 
			      <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Salir ahora">Salir &raquo; </a>  </p>
		<?php else : ?>
			<p>   <label for="author"><small>Nombre </small></label>
				  <input type="text" name="author" id="author" value="<?php echo $comment_author; ?>"  tabindex="1" />
				  <label for="email"><small>Email (no será visible) </small></label>
				  <input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>"  tabindex="2" />  </p>

			<p>   <label for="url"><small>Wb</small></label>
				  <input class="large" type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>"  tabindex="3" />  </p>
				  
		<?php endif; ?>
			<p><textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea>   </p> 
			<p>   <input name="submit" type="submit" id="submit" tabindex="5" value="Enviar Comentario" />
			      <input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />  </p>
			<?php do_action('comment_form', $post->ID); ?>
		</form>
	<?php endif; ?>
<?php else : ?>
	<p>Los comentarios están cerrados.</p>
<?php endif; ?>  


<?php if($comments) : ?>
	<ul>
	<?php foreach($comments as $comment) : ?>
		<li id="comment-<?php comment_ID(); ?>">
		<?php if($comment->comment_approved == '0') { ?>
			<p>Tu comentario está pendiente de aprobación</p>
		<?php } else{ ?>
			<div class="info-comment">
				<div class="usuario"> <?php comment_author_link(); ?> </div>
				<div class="fecha"> <?php comment_date('d/m/Y'); ?> </div>
			</div>
			<?php comment_text(); ?>
		</li>
		<?php }?>
	<?php endforeach; ?>
	</ul>
<?php else : ?>
<p>No hay comentarios</p>
<?php endif; ?>
