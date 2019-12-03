<?php
/*
Template Name: External Object
*/

get_header(); 

	$arr = explode('/toplegal/news', $_SERVER[REQUEST_URI]);
	$ch = curl_init();

	// set url
	//curl_setopt($ch, CURLOPT_URL, "http://82.220.53.74:3000/api/toplegal/contacts?link=" . urlencode("http://toplegal.it/elencoasp/societa/20694/tim-spa"));
	curl_setopt($ch, CURLOPT_URL, "http://82.220.53.74:3000/api/toplegal/contacts?link=" . urlencode("http://toplegal.it".$arr[1]));
	/*curl_setopt($ch, CURLOPT_URL, "http://82.220.53.74:3000/api/toplegal/contacts?link=" . urlencode( $url ));*/

	//return the transfer as a string
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	 // $output contains the output string
	$output = json_decode(curl_exec($ch),true);

	// close curl resource to free up system resources
	curl_close($ch);

	//var_dump( $output );
	//echo get_home_url();
	//echo "<br/>";
	//echo $_SERVER['REQUEST_URI'];
	//$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	//$arr = explode('/toplegal/news', $_SERVER[REQUEST_URI]);
	//echo $arr[1];
	$post_id = $output["id"];
	$title   = $output["name"];
?>
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-3 hidden-xs hidden-sm rs">
		            <?php if ( is_active_sidebar( 'single-post-left-sidebar' ) ) : ?>
		                <?php dynamic_sidebar( 'single-post-left-sidebar' ); ?>
		            <?php endif; ?>
	            </div>
                <div class="col-md-6 ls">
	<article id="post-<?php echo $post_id; ?>" <?php post_class('block'); ?>>
    <span class="date visible-xs"></span>
			<h1 class="title-single-post"><?php echo $title; ?></h1>
			<div>
			<p>Articoli correlati</p>
			<?php 
				foreach ($output["post_slugs"] as $the_slug): 
					$args = array(
					  'name'        => $the_slug,
					  'post_type'   => 'post',
					  'post_status' => 'publish'
					);
					$the_query = new WP_Query($args);
					if ( $the_query->have_posts() ) :
						while ( $the_query->have_posts() ) {
							$the_query->the_post();
							
							get_template_part( 'template-parts/content', 'row-img-plus' );
							
						} 
					endif;
				endforeach; 
			?>
			</div>
			<div class="catenaccio-single"></div>
    <div class="mrkt-chld">
        <div class="pull-left"><i class="fa fa-bookmark" aria-hidden="true"></i>
					<div class="date"><?php the_date(); ?></div>
		</div>
        <div class="pull-right">
		 <?php if ( is_active_sidebar( 'sidebar-for-share' ) ) : ?>
			<div id="sidebar-for-share">
				<?php dynamic_sidebar( 'sidebar-for-share' ); ?>
			</div>
		<?php endif; ?>
		</div>
        <div style="clear: both"></div>
        <div class="arr-down"></div>
    </div>

    <p>
    </p>
    
    
    	<div class="excerpt-single"></div>
    	<hr>
    	
    
    <?php //the_content();?>
    <?php  

		if ( is_active_sidebar( 'single-post-advertising' ) ) :
			dynamic_sidebar( 'single-post-advertising' ); 
		endif;
    ?>
</article>
 <?php //Sidebar "Bottom post content"?>
 <?php if ( is_active_sidebar( 'bottom-post-content' ) ) : ?>
	<div id="sidebar-bottom-post-content">
		<?php dynamic_sidebar( 'bottom-post-content' ); ?>
	</div>
<?php endif; ?>
 <?php if ( is_active_sidebar( 'sidebar-for-share' ) ) : ?>
	<div id="sidebar-for-share">
		<?php dynamic_sidebar( 'sidebar-for-share' ); ?>
	</div>
<?php endif; ?>
                </div>
	            <?php //get_sidebar(); ?>
                <div class="col-md-3 hidden-xs hidden-sm rs">
		            <?php if ( is_active_sidebar( 'single-post-right-sidebar' ) ) : ?>
		                <?php dynamic_sidebar( 'single-post-right-sidebar' ); ?>
		            <?php endif; ?>
	            </div>
            </div>
        </div>
    </section>
    <?php
get_footer();