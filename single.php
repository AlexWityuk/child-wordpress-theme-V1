<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package tecnavia
 */

if ( !isset( $_GET['overlay'] ) ) {

get_header(); ?>
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-3 hidden-xs hidden-sm rs">
		            <?php if ( is_active_sidebar( 'single-post-left-sidebar' ) ) : ?>
		                <?php dynamic_sidebar( 'single-post-left-sidebar' ); ?>
		            <?php endif; ?>
	            </div>
                <div class="col-md-6 ls">
	                <?php //print tecnavia_breadcrumbs(); ?>
	                <?php
	                while ( have_posts() ) : the_post();
	                
	                	//$meta_key = 'post_view_count';
		                tecnavia_set_post_meta_counter(get_the_ID());

		                get_template_part( 'template-parts/content', 'single' );

		                // If comments are open or we have at least one comment, load up the comment template.
		                /*if ( comments_open() || get_comments_number() ) :
			                comments_template();
		                endif;*/

	                endwhile; // End of the loop.
	                ?>
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

} elseif ( isset( $_GET['overlay'] ) ) {
	?>
	<!doctype html>
	<html lang="en" style="height:auto">
	<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_site_icon();?>
	<?php wp_head(); ?> 
	</head>
	<body class="single-post overlayContact">
	<div>
	<?php
    while ( have_posts() ) : the_post();
   
        tecnavia_set_post_meta_counter(get_the_ID());

        get_template_part( 'template-parts/content', 'single-overlay' );

    endwhile; // End of the loop.
    ?>
		</div>
	</body>
</html>
    <?php
}
