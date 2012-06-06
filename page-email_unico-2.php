<?php /*Template Name: email_unico*/ 

	$email = $_POST['email'];//'alala@nfdsnvm.com';
	
	$the_query = new WP_Query( array( 'post_type' => 'email') );
	$is_unique = true;
	$title = '';
	while ( $the_query->have_posts() ) : $the_query->the_post();
		if( get_the_title() == $email ){ $is_unique = false;  break;}
	endwhile;
	wp_reset_postdata();

	$valid = "false";
	if($is_unique){
		$my_post = array(
			 'ID' => '',
		     'post_title' => $email,
		     'post_type' => 'email',
		     'post_status' => 'publish' 
        );
		wp_insert_post( $my_post );
		$valid = "true";
	}

	echo $valid;

?>