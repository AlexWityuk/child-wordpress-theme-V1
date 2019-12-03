<?php 
add_action ( 'admin_enqueue_scripts', 'toplegal_style_admin' );
function toplegal_style_admin() 
{
	wp_enqueue_style( 'child-admin-style', get_stylesheet_directory_uri()  . '/css/admin-style.css' );
	wp_enqueue_script( 'toplegal_child_custom_admin_script', get_stylesheet_directory_uri() .'/js/admin-scripts.js', '', '1.0', true );
 	wp_enqueue_script( 'jquery-ui-autocomplete' );
	wp_localize_script('toplegal_child_custom_admin_script', 'admin_toplegal_ajax', array('url' => admin_url('admin-ajax.php')));
}
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles',20 );
function enqueue_parent_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'parent-style' ));
	wp_enqueue_script( 'tecnavia-animation-child-js',  get_stylesheet_directory_uri() . '/js/scripts-child.js', array(), '20151215', true );
	wp_localize_script('tecnavia-animation-child-js', 'toplegal_ajax', array('url' => admin_url('admin-ajax.php'))); 
}

/*-------------------------------------------------------------------------*/
/* Ajax
/*-------------------------------------------------------------------------*/
add_action( 'wp_ajax_moreResults_action', 'toplegal_website_child_guida_item_search_action' );
add_action( 'wp_ajax_nopriv_moreResults_action', 'toplegal_website_child_guida_item_search_action' );

function toplegal_website_child_guida_item_search_action() {
	if ( isset( $_POST['search-guida-item-type'] ) ) {
		//echo '**Hello more results!!!**'. $_POST['search-guida-item-type'];
		$post_type = $_POST['search-guida-item-type']; 
		require get_template_directory() . '/../tecnavia-child/inc/get-externalstudio-professionisti-list.php';

	}
	wp_die();
}
/*
add_action( 'wp_ajax_my_action', 'toplegal_website_child_my_action' );
add_action( 'wp_ajax_nopriv_my_action', 'toplegal_website_child_my_action' );

function toplegal_website_child_my_action() {
	    	global $wp;
	        $string = '';
    if (isset($_POST["itemid"])) {
		$current_url = home_url( $wp->request );
        $ch = curl_init();
        
        // set url
        //curl_setopt($ch, CURLOPT_URL, "http://82.220.53.74:3000/api/toplegal/contacts/" . $_POST["itemid"]); //old url
        curl_setopt($ch, CURLOPT_URL, "https://crm.newsmemory.com:8143/api/toplegal/contacts/".urlencode($_POST["itemid"]));

		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJjbGllbnRfYXBwIjoidG9wbGVnYWxfd29yZHByZXNzIn0.4pZlmokVU3P5J1I415a9OUR1oE2w8PhZRiB7O1dmH-k'
		));
        
        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        //echo $output;
        // $output contains the output string
        $output = json_decode($output,true);
        
        // close curl resource to free up system resources
        curl_close($ch);

        if (count($output) > 0) {
            $string = $string .'<h1>'.$output["name"].'</h1><hr>';
            
            if (array_key_exists("post_slugs", $output) && $output["post_slugs"] > 0) {
            
            $string = $string.'<div class="newsCorrelateTitle">News correlate</div>
            <ul class="newsCorrelateList">';
            
            $relatedPosts = array();
            
            //print_r($output);
            
            foreach  ($output["post_slugs"] as $slug) {
                
                $post_ids = get_posts(array
                    (
                        'name'   => $slug,
                        'post_type'   => "post",
                        'posts_per_page' => 1
                        
                    ));
                
              $relatedPosts[] =  $post_ids;
                
            }
            
            
            foreach ($relatedPosts as $post) {
                $_post = $post[0];
                $string = $string.'<li>
                    <span class="date">'.$_post->post_date.'</span>
                    <a class="fancybox fancybox.iframe  post"  data-fancybox-type="iframe"  href="'. get_permalink($_post->ID).'?overlay=1">'.$_post->post_title.'</a>
                </li>';   
            }  
            $string = $string.'</ul>';
        	}   
        } 
    }
    echo $string;
    wp_die();
}
*/
add_action( 'wp_ajax_search_action', 'toplegal_website_child_search_action' );
add_action( 'wp_ajax_nopriv_search_action', 'toplegal_website_child_search_action' );

function toplegal_website_child_search_action() {
	if ( isset( $_POST['search'] ) ) {
		// create curl resource
		$ch = curl_init();

		// set url
	  	//curl_setopt($ch, CURLOPT_URL, sprintf("http://82.220.53.74:3000/api/toplegal/contacts?type[]=%s&q=%s", $_POST['type'],  $_POST['search'] ));
	  	curl_setopt($ch, CURLOPT_URL, sprintf("https://crm.newsmemory.com:8143/api/toplegal/contacts?type[]=%s&q=%s", $_POST['type'],  $_POST['search'] ));
        //curl_setopt($ch, CURLOPT_URL, "https://crm.newsmemory.com:8143/api/toplegal/contacts/".urlencode($_POST["itemid"]));

		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJjbGllbnRfYXBwIjoidG9wbGVnYWxfd29yZHByZXNzIn0.4pZlmokVU3P5J1I415a9OUR1oE2w8PhZRiB7O1dmH-k'
		));

		//return the transfer as a string
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		// $output contains the output string
		$output = curl_exec($ch);
		//echo $output;
        $output = json_decode($output,true);
		//echo $output;
		// close curl resource to free up system resources
		curl_close($ch);

		$str = '<div class="sctn active">';
		foreach ($output as $value) {
			$str = $str .'<div class="filterDiv professionist active"><a href="" id="'.$value['id'].'">'.$value['name'].'</a></div>';
			//echo $value;
		}
		$str = $str.'</div>';
		echo $str;
	}
	wp_die();
}
add_action( 'wp_ajax_my_admin_action', 'Autocomplete_my_admin_action' );

function Autocomplete_my_admin_action() {
    $post_type='';
    $curl_url = '';
	if ( isset( $_POST['directory'] ) ) {
		$post_type = $_POST['directory'];
        // set url
        if ($post_type == 'studio') $curl_url = "http://82.220.53.74:3000/api/toplegal/contacts?type[]=societa&type[]=".$post_type; 
    	elseif($post_type  == 'professionista') $curl_url = "http://82.220.53.74:3000/api/toplegal/contacts?type[]=".$post_type;
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $curl_url);
        
        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// $output contains the output string
		$output = curl_exec($ch);
        // $output contains the output string
        //$output = json_decode(curl_exec($ch),true);
        
        // close curl resource to free up system resources
        curl_close($ch);
        
        if (count($output) > 0) {
            foreach ($output as $post) {
            	// do something;
            }
        }
        echo $output;
	}
	wp_die();
}

add_action( 'wp_ajax_search_admin_external_item_action', 'toplegal_website_child_search_admin_external_item_action' );

function toplegal_website_child_search_admin_external_item_action() {
	if ( isset( $_POST['search_admin_external_word'] ) ) {
		//echo "ajax response** !!";
		$searchword = $_POST['search_admin_external_word'];
		$post_type = $_POST['type'];
		// create curl resource
		$ch = curl_init();

		// set url
		//curl_setopt($ch, CURLOPT_URL, "https://crm.newsmemory.com:8143/api/toplegal/contacts?link=" . urlencode($searchword));
		curl_setopt($ch, CURLOPT_URL, "https://crm.newsmemory.com:8143/api/toplegal/contacts?type[]=".$post_type."&q=".$searchword );
		//curl_setopt($ch, CURLOPT_URL, "https://crm.newsmemory.com:8143/api/toplegal/contacts?type[]=professionista&q=".$searchword );


		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJjbGllbnRfYXBwIjoidG9wbGVnYWxfd29yZHByZXNzIn0.4pZlmokVU3P5J1I415a9OUR1oE2w8PhZRiB7O1dmH-k'
		));

		//return the transfer as a string
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		// $output contains the output string
		$output = curl_exec($ch);
		//echo $output;
        $output = json_decode($output,true);
        $total_items = count($output);
		// close curl resource to free up system resources
		curl_close($ch);

		//echo  $output ;

		$str = '<div class="rcbScroll rcbWidth" style="height: 277.011px;"><ul class="rcbList" style="list-style:none;margin:0;padding:0;zoom:1;">';
		foreach ($output as $value) {
			if ( $post_type == 'studio' ) 
			$str = $str .'<li class="rcbItem" post-type="'.$post_type.'" id="'.$value['id'].'">'.$value['name'].'</li>';
			elseif ( $post_type == 'professionista' )
			$str = $str .'<li class="rcbItem" post-type="'.$post_type.'" id="'.$value['id'].'">'.$value['first_name'].' '.$value['last_name'].'</li>';
			//echo $value;
		}
		$str = $str.'</ul></div>';
		echo $str.'**&**'.'<span>Items <b>1</b>-<b>'.$total_items.'</b> out of <b>'.$total_items.'</b></span>';
	}
	wp_die();
}

//Ajax

function tecnavia_widgets_init_child() {

	unregister_widget('Homepage_Fullwidth_Post_Carousel');
	unregister_widget('Widget_Posts_List_Category_Img_Plus');
	unregister_widget('Widget_Posts_List_Category_Img_Plus_Double');
    
    for ($i=1; $i < 4; $i++) { 
		register_sidebar( array(
			'name' 			=> esc_html__( 'Guida footer Sidebar '.$i, 'tecnavia' ),
			'id' 			=> 'guida-footer-sidebar-'.$i,
			'description' 	=> esc_html__( 'Appears in the guida footer section', 'tecnavia' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );
    }

	register_sidebar( array(
			'name'          => esc_html__( 'Editoria Direzioni e Impresa Page Sidebar', 'tecnavia' ),
			'id'            => 'editoria_direzioni_e_impresa_page_sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'tecnavia' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
	) );
	register_sidebar( array(
			'name'          => esc_html__( 'Editoria Analisi Page Sidebar', 'tecnavia' ),
			'id'            => 'editoria_analisi_page_sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'tecnavia' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
	) );
	register_sidebar( array(
			'name'          => esc_html__( 'Editoria Notizie Page Sidebar', 'tecnavia' ),
			'id'            => 'editoria_notizie_page_sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'tecnavia' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
	) );
	register_sidebar( array(
			'name'          => esc_html__( 'Bottom Page Sidebar', 'tecnavia' ),
			'id'            => 'bottom_page_sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'tecnavia' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
	) );
	register_sidebar( array(
			'name'          => esc_html__( 'Posts Category Double Sidebar', 'tecnavia' ),
			'id'            => 'homepge_posts_category_img_plus_double_sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'tecnavia' ),
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '',
			'after_title'   => '',
	) );

	register_sidebar( array(
			'name'          => esc_html__( 'Homepage Fullwidth Post Carousel', 'tecnavia' ),
			'id'            => 'homepage_fullwidth_post_carousel',
			'description'   => esc_html__( 'Add widgets here.', 'tecnavia' ),
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '',
			'after_title'   => '',
	) );
	
	register_sidebar( array(
			'name'          => esc_html__( 'Homepage Fullwidth Left', 'tecnavia' ),
			'id'            => 'homepage-fullwidth-left',
			'description'   => esc_html__( 'Add widgets here.', 'tecnavia' ),
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '',
			'after_title'   => '',
	) );
	
	
	register_sidebar( array(
			'name'          => esc_html__( 'Homepage Fullwidth Right', 'tecnavia' ),
			'id'            => 'homepage-fullwidth-right',
			'description'   => esc_html__( 'Add widgets here.', 'tecnavia' ),
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '',
			'after_title'   => '',
	) );
	

	register_sidebar( array(
			'name'          => esc_html__( 'Homepage Fullwidth Bottom Right', 'tecnavia' ),
			'id'            => 'homepage-fullwidth-bottom-right',
			'description'   => esc_html__( 'Add widgets here.', 'tecnavia' ),
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '',
			'after_title'   => '',
	) );
	
	register_sidebar( array(
			'name'          => esc_html__( 'Homepage Fullwidth Bottom Left', 'tecnavia' ),
			'id'            => 'homepage-fullwidth-bottom-left',
			'description'   => esc_html__( 'Add widgets here.', 'tecnavia' ),
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '',
			'after_title'   => '',
	) );
	
	register_sidebar( array(
			'name'          => esc_html__( 'Before Footer', 'tecnavia' ),
			'id'            => 'before-footer-sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'tecnavia' ),
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '',
			'after_title'   => '',
	) );
	
	register_sidebar( array(
			'name'          => esc_html__( 'Footer Right', 'tecnavia' ),
			'id'            => 'footer-right-sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'tecnavia' ),
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '',
			'after_title'   => '',
	) );
	register_sidebar( array(
			'name'          => esc_html__( 'Single Post Left Sidebar', 'tecnavia' ),
			'id'            => 'single-post-left-sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'tecnavia' ),
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '',
			'after_title'   => '',
	) );
	register_sidebar( array(
			'name'          => esc_html__( 'Single Post Right Sidebar', 'tecnavia' ),
			'id'            => 'single-post-right-sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'tecnavia' ),
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '',
			'after_title'   => '',
	) );
	register_sidebar( array(
			'name'          => esc_html__( 'Single Post Advertising', 'tecnavia' ),
			'id'            => 'single-post-advertising',
			'description'   => esc_html__( 'Add widgets here.', 'tecnavia' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
	) );
	register_sidebar( array(
			'name'          => esc_html__( 'Directory Studi Sidebar', 'tecnavia' ),
			'id'            => 'directory-studi-sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'tecnavia' ),
			'before_widget' => '<div class="ads-dir" id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
	) );
	register_sidebar( array(
			'name'          => esc_html__( 'Archive Company Top Sidebar', 'tecnavia' ),
			'id'            => 'archive-company-top-sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'tecnavia' ),
			'before_widget' => '<div class="archive-ads-dir" id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
	) );
	register_sidebar( array(
			'name'          => esc_html__( 'Archive Bottom Sidebar', 'tecnavia' ),
			'id'            => 'archive-bottom-sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'tecnavia' ),
			'before_widget' => '<div class="archive-ads-dir" id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
	) );
	register_sidebar( array(
			'name'          => esc_html__( 'Diritto A-Z Sidebar', 'tecnavia' ),
			'id'            => 'diritto-a-z-sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'tecnavia' ),
			'before_widget' => '<div class="right-sidebar-ads-dir" id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
	) );
	register_sidebar( array(
			'name'          => esc_html__( 'Diritto A-Z Single Post Left', 'tecnavia' ),
			'id'            => 'single-diritto_az-post-left-sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'tecnavia' ),
			'before_widget' => '<div class="right-sidebar-ads-dir diritto_az-left-sdbr" id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
	) );
	register_sidebar( array(
			'name'          => esc_html__( 'Diritto A-Z Single Poast Right', 'tecnavia' ),
			'id'            => 'single-diritto_az-post-right-sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'tecnavia' ),
			'before_widget' => '<div class="right-sidebar-ads-dir diritto_az-right-sdbr" id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
	) );
	register_sidebar( array(
			'name'          => esc_html__( 'Diritto A-Z Single Poast Bottom', 'tecnavia' ),
			'id'            => 'single-diritto_az-post-bottom-sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'tecnavia' ),
			'before_widget' => '<div class="right-sidebar-ads-dir diritto_az-bottom-sdbr" id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
	) );
	register_sidebar( array(
			'name'          => esc_html__( 'White Paper Logo Widget', 'tecnavia' ),
			'id'            => 'white-paper-widget-logo',
			'description'   => esc_html__( 'Add widgets here.', 'tecnavia' ),
			'before_widget' => '<div class="white-paper-logo-sdbr" id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'tecnavia_widgets_init_child',11 );
/*--------------------------------------------------------------------------------*/
/* Sub menu init
/*--------------------------------------------------------------------------------*/
function tecnavia_child_register_my_menu() {
  register_nav_menu( 'editoria_sub_menu', __( 'Editoria Sub Menu' ) );
  register_nav_menu( 'eventi_sub_menu', __( 'Eventi Sub Menu' ) );
  register_nav_menu( 'awards_sub_menu', __( 'Awards Sub Menu' ) );
  register_nav_menu( 'consulting_sub_menu', __( 'Consulting Sub Menu' ) );
  register_nav_menu( 'formazione_sub_menu', __( 'Formazione Sub Menu' ) );
  register_nav_menu( 'hamburger_menu_col_one', __( 'Hamburger menu column one' ) );
  register_nav_menu( 'hamburger_menu_col_two', __( 'Hamburger menu column two' ) );
  register_nav_menu( 'hamburger_menu_col_three', __( 'Hamburger menu column three' ) );
  register_nav_menu( 'diritto-a-z-sidebar-menu', __( 'Diritto A-Z Sidebar Menu' ) );
  register_nav_menu( 'guida-metodologia-menu', __( 'Guida Metodologia Menu' ) );
  register_nav_menu( 'guida-partecipare-menu', __( 'Guida Partecipare Menu' ) );
}
add_action( 'init', 'tecnavia_child_register_my_menu' );

/*--------------------------------------------------------------------------------*/
/* End Section Menu init
/*--------------------------------------------------------------------------------*/

//require get_template_directory() . '/../tecnavia-child/inc/widget-section-menu.php';
require get_template_directory() . '/../tecnavia-child/inc/widget-agenda-post-list.php';
require get_template_directory() . '/../tecnavia-child/inc/widget-homepage-fullwidth-carousel-post.php';
require get_template_directory() . '/../tecnavia-child/inc/custom-post-type.php';
require get_template_directory() . '/../tecnavia-child/inc/widget-posts-list-category-img-plus-double.php';
require get_template_directory() . '/../tecnavia-child/inc/widget-most-read-posts.php';
require get_template_directory() . '/../tecnavia-child/inc/widget-homepage-in-evidenza-posts.php';
require get_template_directory() . '/../tecnavia-child/inc/widget-posts-specific-categories-three-col.php';
require get_template_directory() . '/../tecnavia-child/inc/widget-osservatori-post-list.php';
require get_template_directory() . '/../tecnavia-child/inc/widget-last-youtube-video.php';
require get_template_directory() . '/../tecnavia-child/inc/widget-analisi-posts-img-category-slug.php';
require get_template_directory() . '/../tecnavia-child/inc/widget-notizie-posts-list-by-category-slug.php';
require get_template_directory() . '/../tecnavia-child/inc/widget-altre-news-posts-list.php';
require get_template_directory() . '/../tecnavia-child/inc/widget-menu-of-categories-sidebar.php';
require get_template_directory() . '/../tecnavia-child/inc/widget-get-recent-white_papers_posts.php';
require get_template_directory() . '/../tecnavia-child/inc/widget-white-paper-lateest-posts.php';
require get_template_directory() . '/../tecnavia-child/inc/custom-metaboxes.php';
require get_template_directory() . '/../tecnavia-child/inc/wp-list-table-guida-item.php';

function white_paper_widget_excerpt_length( $length ) {
	return 6;
}
add_filter( 'excerpt_length', 'white_paper_widget_excerpt_length', 999 );

register_activation_hook( __FILE__, 'pmg_rewrite_activation' );
function pmg_rewrite_activation()
{
    pmg_rewrite_add_rewrites();
    flush_rewrite_rules();
}

function my_page_template_redirect(){
	if( strpos( $_SERVER[REQUEST_URI] , 'elencoasp' ) !== false || strpos( $_SERVER[REQUEST_URI] , 'centrostudi' ) !== false   ){
	     // load the file if exists
 		$load = locate_template('external-object.php', true);
     	if ($load) {
        	exit(); // just exit if template was found and loaded
     	}
	}
}
add_action( 'init', 'my_page_template_redirect' );