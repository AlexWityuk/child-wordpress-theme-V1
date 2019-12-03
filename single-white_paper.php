<?php
/**
 * The template for displaying white_paper single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package tecnavia
 */

get_header(); ?>
    <section class="content">
        <div class="container">
        	<div class="hieght-diritt hidden-xs hidden-sm"></div>
            <div class="row">
                <div class="col-md-2  hidden-xs hidden-sm rs">
        	        <div class="nnfgt">
			            <div class="post-placeholder">
			                <h4>Mercati dei capitali e finanza strutturata</h4>
			            </div>
			            <div class="date"><?php echo get_the_date('j F Y'); ?></div>
			        </div>
                	<?php
                	while ( have_posts() ) : the_post(); ?>
            		    <p>
					        <?php print tecnavia_get_post_image('big_image', 'img-responsive', '', false, false); ?>
					    </p>
                	
                	<?php endwhile; ?>
		            <?php if ( is_active_sidebar( 'single-diritto_az-post-left-sidebar' ) ) : ?>
		                <?php dynamic_sidebar( 'single-diritto_az-post-left-sidebar' ); ?>
		            <?php endif; ?>
	            </div>
                <div class="col-md-offset-1 col-md-4 ls">
	                <?php
	                while ( have_posts() ) : the_post();

		                tecnavia_set_post_meta_counter(get_the_ID());

		                get_template_part( 'template-parts/content', 'single-diritto-a-z' );

	                endwhile; // End of the loop.
	                ?>

		            <?php if ( is_active_sidebar( 'single-diritto_az-post-bottom-sidebar' ) ) : ?>
		                <?php dynamic_sidebar( 'single-diritto_az-post-bottom-sidebar' ); ?>
		            <?php endif; ?>
                </div>
                <div class="col-md-offset-1 col-md-4 hidden-xs hidden-sm rs">
                	<?php
	                    $wp_query = new WP_Query( array(
		                    'post_type'      => 'diritto_az',
		                    'posts_per_page' => 3
		                ) );

		                if ($wp_query->have_posts()) {
		                	?>
		                	<div class="lst-diritt-psts">
		                        <div class="wrap">
		                            <i class="fa fa-bookmark" aria-hidden="true"></i> 
		                            <span>AGGIORNAMENTI CORRELATI</span>
		                            <div class="arr-down"></div>
		                        </div> 
		                	<?php
			                    while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
				                    <div class="sngl-pst-wrap">
		                                <h4 class="entry-title">
							                <a href="<?php print esc_url( get_permalink() ) ?>"
							                    title="<?php the_title_attribute(); ?>"><?php the_title(); ?>
							                </a>
							            </h4>
							            <div class="row">
    				                    	<div class="col-md-6">
						                        <div class="post-placeholder">
									                <h4>Mercati dei capitali e finanza strutturata</h4>
									            </div>
									            <div class="date"><?php echo get_the_date('j F Y'); ?></div>
					                    	</div>
					                    	<div class="col-md-6"></div>
							            </div>
				                    </div>
			                    <?php endwhile;?>
                            </div>
		                    <?php
		                }
		                
		                wp_reset_query();
                	?>

		            <?php if ( is_active_sidebar( 'single-diritto_az-post-right-sidebar' ) ) : ?>
		                <?php dynamic_sidebar( 'single-diritto_az-post-right-sidebar' ); ?>
		            <?php endif; ?>
	            </div>
            </div>
        </div>
    </section>
<?php
	get_footer();
?>