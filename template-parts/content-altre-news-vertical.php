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
        <div class="col-xs-12 col-sm-12 col-md-12 post-content">
            <?php if (!empty($occhiello)) :?>
            <h4 class="occhiello"><span><?php echo $occhiello; ?></span></h4>
        <?php else: ?>
            <h4 class="occhiello hidden-xs"><span><?php echo $occhiello; ?></span></h4>
        <?php endif; ?>
            <h4 class="entry-title"><a href="<?php print esc_url( get_permalink() ) ?>"
                       title="<?php the_title_attribute(); ?>"><?php print tecnavia_get_excerpt($title, 40); //tecnavia_get_content_searched_highlight( $title ); ?></a>
            </h4>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 post-image">
            <?php print tecnavia_set_post_background(); ?>
            <div class="ite visible-xs">
                <div class="right-news">
                    <?php print tecnavia_get_post_image( array( 345, 'auto' ), 'img-responsive' ); ?>
                    
                </div>
            </div>
            <div class="post-meta col-sm-12 col-md-12 ">
                <div class="date"><?php the_date(); ?></div>
            </div>
        </div> `
    </div>
</div>