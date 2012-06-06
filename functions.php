<?php 
function taxonomias() {
  register_taxonomy('tags-pu', 'post', array(
  'hierarchical' => true, 'label' => 'Tags_PU',
  'query_var' => true, 'rewrite' => true));

  register_taxonomy('secciones', 'post', array(
  'hierarchical' => true, 'label' => 'Secciones',
  'query_var' => true, 'rewrite' => true));

  register_taxonomy('categorias', 'post', array(
  'hierarchical' => true, 'label' => 'Categorias',
  'query_var' => true, 'rewrite' => true));
}
add_action('init', 'taxonomias', 0);

//Agregar Post Types
 add_action( 'init', 'create_post_type_foros' );
    function create_post_type_foros() {
        register_post_type( 'foro',
            array(
                'labels' => array(
                    'name' => __( 'Foros' ),
                    'singular_name' => __( 'Foro' ),
                    'singular_label' => __( 'Foro' ),
                    'all_items' => __('Foros'),
                    'add_new_item' => __('Add a new foro'),
                    'edit_item' => __('Edit foro')
                ),
            'public' => true,
            'has_archive' => true,
            'capability_type' => 'post',
            'hierarchical' => true,
            'query_var' => true,
            'menu_position' => 5,
            'rewrite' => array('slug' => 'foros'),
            'supports' => array( 'title', 'comments', 'editor', 'excerpt', 'custom-fields', 'thumbnail' ),
            'taxonomies' => array('tags-pu', 'categorias')
            )
        );
    }

//Agregar Post Types
 add_action( 'init', 'create_post_type_email' );
    function create_post_type_email() {
        register_post_type( 'email',
            array(
                'labels' => array(
                    'name' => __( 'Email' ),
                    'singular_name' => __( 'Email' ),
                    'singular_label' => __( 'Email' ),
                    'all_items' => __('Emails'),
                    'add_new_item' => __('Add a new email'),
                    'edit_item' => __('Edit email')
                ),
            'public' => true,
            'has_archive' => true,
            'capability_type' => 'post',
            'hierarchical' => true,
            'rewrite' => false,
            'query_var' => true,
            'menu_position' => 5,
            'rewrite' => array('slug' => 'emails'),
            'supports' => array( 'title')
            )
        );
    }



//related post shortcode
function related_posts_shortcode( $atts ) {

    extract(shortcode_atts(array(
    'limit' => '5',
    ), $atts));

    global $wpdb, $post, $table_prefix;

    if ($post->ID) {
    $retval = '<ul>';

    // Get tags
    $tags = wp_get_post_tags($post->ID);
    $tagsarray = array();
    foreach ($tags as $tag) $tagsarray[] = $tag->term_id;
    $tagslist = implode(',', $tagsarray);

    // Do the query
    $q = "
    SELECT p.*, count(tr.object_id) as count
    FROM $wpdb->term_taxonomy AS tt, $wpdb->term_relationships AS tr, $wpdb->posts AS p
    WHERE tt.taxonomy ='post_tag'
    AND tt.term_taxonomy_id = tr.term_taxonomy_id
    AND tr.object_id  = p.ID
    AND tt.term_id IN ($tagslist)
    AND p.ID != $post->ID
    AND p.post_status = 'publish'
    AND p.post_date_gmt < NOW() GROUP BY tr.object_id ORDER BY count DESC, p.post_date_gmt DESC LIMIT $limit;";         

    $related = $wpdb->get_results($q);

    if ( $related ) {
        foreach($related as $r) {
            $retval .= '<li><a title="'.wptexturize($r->post_title).
                       '" href="'.get_permalink($r->ID).'">'.
                       wptexturize($r->post_title).'</a></li>';
        }
    } else {
        $retval .= '<li>No related posts found</li>';
    }
    $retval .= '</ul>';
        return $retval;
    }
        return;
}
add_shortcode('related_posts', 'related_posts_shortcode');

// get taxonomies terms links
function custom_taxonomies_terms_links() {
    global $post, $post_id;
    // get post by post id
    $post = &get_post($post->ID);
    // get post type by post
    $post_type = $post->post_type;
    // get post type taxonomies
    $taxonomies = get_object_taxonomies($post_type);
    foreach ($taxonomies as $taxonomy) {
        // get the terms related to post
        $terms = get_the_terms( $post->ID, $taxonomy );
        if ( !empty( $terms ) ) {
            $out = array();
            foreach ( $terms as $term )
                $out[] = '<a href="' .get_term_link($term->slug, $taxonomy) .'">'.$term->name.'</a>';
            $return = join( ', ', $out );
        }
    }
    return $return;
}

function custom_excerpt_length( $length ) {   return 20;}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

//Imagenes 
add_theme_support( 'post-thumbnails' );

add_action( 'after_setup_theme', 'setup' );  
function setup() {  
    add_theme_support( 'post-thumbnails' ); 
    
    add_image_size( 'post', 450, 450, true ); // Unlimited Height Mode
    add_image_size( 'banner', 700, 300, true); //, true Hard Crop Mode
    add_image_size( 'preview', 220, 290, true ); // Soft Crop Mode
    add_image_size( 'releated', 200, 100,true ); // Soft Crop Mode
    add_image_size( 'carrucel', 71, 50); // Soft Crop Mode
} 

add_filter( 'image_size_names_choose', 'custom_image_sizes_choose' );  
function custom_image_sizes_choose( $sizes ) {  
    $custom_sizes = array( 'post' => 'Post',  
                           'banner' => 'Banner',
                           'preview' => 'Preview',
                           'releated' => 'Releated'  );  
    return array_merge( $sizes, $custom_sizes );  
}  


// Widget de Twitter
    function getTwitterStatus($name, $count){
     
        $transient = "$name"."_$count";
        //Get Tweets From the Cache
        $getTweets = get_transient($transient);
        if ($getTweets){
            echo $getTweets;
        }
        elseif ($name != false){
            $site = "http://twitter.com/statuses/user_timeline.json?screen_name=$name&count=$count";
            //Perform Http request to get JSON feed of Twitter User Status
            $result = wp_remote_get($site);
            $json = $result['body'];
            //Convert JSON String to PHP Array
            $tweets = json_decode($json);
            $getTweets = '';
     
            foreach ( (array) $tweets as $tweet){
     
                // Convert twitter Usernames and links to Hyperlinks
                $tweetcontent = linkify($tweet->text);
                $status_id = $tweet->id;

                $DAY_TO_SEC = 86400; $HOUR_TO_SEC = 3600; $MINUTE_TO_SEC = 60;
                
                $ago_sec = time() - strtotime($tweet->created_at);
                    
                if($ago_sec >= $DAY_TO_SEC){ $divisor = $DAY_TO_SEC; $unit = 'day';}
                elseif($ago_sec >= $HOUR_TO_SEC){ $divisor = $HOUR_TO_SEC; $unit = "hour";}
                else{ $divisor = $MINUTE_TO_SEC; $unit = "minute";}

                $ago_time = intval($ago_sec / $divisor);
                $ago_time = ($ago_time == 0)? 1: $ago_time; // Si es menos de un minuto, consideralo como un minuto

                $plural = ($ago_time>1)? 's': ''; // Soporte para unidades en plural

                $ago_message = 'ago ';
                $ago_message.= ($unit == 'day' && $ago_time > 30)? ' more than a mouth ' // más de un mes
                                                                 :  $ago_time . ' ' . $unit . $plural ; //

                $getTweets .= "<li>
                                    <div class='mensaje'> $tweetcontent </div>
                                    <div class='coletilla'></div>
                                    <div class='info'>
                                        <a class='tiempo' href='https://twitter.com/jegs87/status/$status_id'>  $ago_message </a> - 
                                        <a class='reply' href='https://twitter.com/intent/tweet?in_reply_to=$status_id'> reply </a>
                                    </div 
                                </li>";
            }
     
            set_transient($transient, $getTweets, 10);
            echo $getTweets;
        }
        else{
            return false;
        }
    }
     
    /* Credit Jeremy Parrish http://rrish.org/  */
    function linkify($status_text){
      // linkify URLs
      $status_text = preg_replace( '/(https?:\/\/\S+)/',
                                   '<a href="\1">\1</a>',
                                    $status_text );
     
      // linkify twitter users
      $status_text = preg_replace( '/(^|\s)@(\w+)/', 
                                   '\1@<a href="http://twitter.com/\2">\2</a>',
                                   $status_text );
     
      // linkify tags
      $status_text = preg_replace( '/(^|\s)#(\w+)/',
                                   '\1#<a href="http://search.twitter.com/search?q=%23\2">\2</a>',
                                   $status_text );
     
      return $status_text;
    }

   


?>


