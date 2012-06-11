<?php 
//Agregar Taxonomias
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
            'taxonomies' => array('tags-pu', 'categorias', 'post_tag')
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


//Post relacionados
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


// Igresar email si no esta repetido (usado con Ajax)
    function insert_email(){
        $email = $_POST['email'];//'alala@nfdsnvm.com';
    
        $the_query = new WP_Query( array( 'post_type' => 'email') );
        $is_unique = true;
        $title = '';
        while ( $the_query->have_posts() ) : $the_query->the_post();
            if( get_the_title() == $email ){ $is_unique = false;  break;}
        endwhile;
        wp_reset_postdata();

        if($is_unique){
            $my_post = array(
                 'post_title' => $email,
                 'post_type' => 'email',
                 'post_status' => 'publish' 
            );
            wp_insert_post( $my_post );
        }
    
        die($is_unique);
    }

    add_action( 'wp_ajax_nopriv_insert_email', 'insert_email' );  
    add_action( 'wp_ajax_insert_email', 'insert_email' );


//Metaboxes

    //agregando custom fields//
    define('MY_WORDPRESS_FOLDER',$_SERVER['DOCUMENT_ROOT']);
    define('MY_THEME_FOLDER',str_replace("\\",'/',dirname(__FILE__)));
    define('MY_THEME_PATH','/' . substr(MY_THEME_FOLDER,stripos(MY_THEME_FOLDER,'wp-content')));
    add_action('admin_init','my_meta_init');
    function my_meta_init(){
        add_meta_box('my_all_meta', 'Datos del Foro/Conferencista', 'my_meta_setup', 'foro', 'normal', 'high');
        add_action('save_post','my_meta_save');
    }

    function my_meta_setup(){
        global $post;
        $meta = get_post_meta($post->ID,'_my_meta',TRUE);
        echo '<div class="my_meta_control">
                <p> 
                    <p> <label>Bliografía:</label> </p>
                    <textarea name="_my_meta[biografia]" cols="115" rows="5">';
                        if(!empty($meta['biografia'])) echo $meta['biografia']; 
              echo '</textarea> 
                </p>
                
                <p>
                    <label>Nombre de la Plática:</label> &nbsp &nbsp
                    <input type="text" name="_my_meta[platica]" value="';
                        if(!empty($meta['platica'])) echo $meta['platica']; echo '"/> 

                    &nbsp &nbsp &nbsp &nbsp &nbsp

                    <label>Id del Video:</label> &nbsp &nbsp
                    <input type="text" name="_my_meta[video_id]" value="';
                        if(!empty($meta['video_id'])) echo $meta['video_id']; echo '"/>
                    <span style="color:#777; font-size:0.9em" > youtube.com/watch?v=<b>NTv9gqMMe48</b> </span>   
                    
                </p>
                    <label>Nombre del Foro:</label>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 
                    <input type="text" name="_my_meta[foro]" value="';
                        if(!empty($meta['foro'])) echo $meta['foro']; echo '"/>
                <p>
                    
                </p>
            </div>';
     
        // create a custom nonce for submit verification later
        echo '<input type="hidden" name="my_meta_noncename" value="' . wp_create_nonce(__FILE__) . '" />';
    }
     
    function my_meta_save($post_id){
        if (!wp_verify_nonce($_POST['my_meta_noncename'],__FILE__)) return $post_id;

        if ($_POST['post_type'] == 'foro'){
            if (!current_user_can('edit_page', $post_id)) return $post_id;
        }else{
            if (!current_user_can('edit_post', $post_id)) return $post_id;
        }

        $current_data = get_post_meta($post_id, '_my_meta', TRUE); 
        $new_data = $_POST['_my_meta'];
        my_meta_clean($new_data);

        if ($current_data){
            if (is_null($new_data)) delete_post_meta($post_id,'_my_meta');
            else update_post_meta($post_id,'_my_meta',$new_data);

        }elseif (!is_null($new_data)){
            add_post_meta($post_id,'_my_meta',$new_data,TRUE);
        }
     
        return $post_id;
    }
     
    function my_meta_clean(&$arr){
        if (is_array($arr)){
            foreach ($arr as $i => $v){
                if (is_array($arr[$i])){
                    my_meta_clean($arr[$i]); if (!count($arr[$i])){ unset($arr[$i]); }
                }else{ if (trim($arr[$i]) == ''){ unset($arr[$i]);  } }
            }
     
            if (!count($arr)){ $arr = NULL;}
        }
    }


// Formulario de búsqueda
?>


