<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package tecnavia
 */
$bg                 = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
$occhiello          = get_post_meta( get_the_ID(), 'post_occhiello', true );
$title              = get_the_title();
$catenaccio         = get_post_meta( get_the_ID(), 'post_catenaccio', true );
$featured           = get_post_meta( get_the_ID(), '_is_ns_featured_post', true );
$featured_class     = $featured == 'yes' ? 'post-featured' : '';

$excerpt = get_the_excerpt();
$content = get_the_content();



/*----------------------------------------------------*/
//
$post_id = get_the_ID();
?>
<div id="post-<?php the_ID(); ?>" <?php post_class( array( $featured_class, 'block-underlined', 'content-row' ) ); ?>>
    <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-3">
            <div class="post-placeholder">
                <h4>Mercati dei capitali e finanza strutturata</h4>
            </div>
            <div class="date"><?php echo get_the_date('j F Y'); ?></div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 post-content">
            <h4 class="entry-title">
                <a href="<?php print esc_url( get_permalink() ) ?>"
                    title="<?php the_title_attribute(); ?>"><?php the_title(); ?>
                </a>
            </h4>
            <p><?php print tecnavia_get_excerpt($content, 120); ?></p>
        </div>
        <div class="post-meta col-xs-12 col-sm-3 col-md-3">
            <div class="visible-xs"><?php //print tecnavia_set_post_background(); ?></div>
            <div class="ite">
                <div class="right-news">
                    <?php print tecnavia_get_post_image( array( 345, 'auto' ), 'img-responsive' ); ?>
                </div>
            </div>
        </div> 
    </div>
</div>