<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package tecnavia
 */
global $num_post;
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
    <div class="wrap-title">
        <h1><?php echo $num_post; ?></h1>
        <?php if (!empty($occhiello)) : ?>
            <h4 class="occhiello"><span><?php echo $occhiello; ?></span></h4>
        <?php endif; ?>
        <h4 class="entry-title"><a href="<?php print esc_url( get_permalink() ) ?>"
                   title="<?php the_title_attribute(); ?>"><?php print $title; //tecnavia_get_content_searched_highlight( $title ); ?></a>
        </h4>
    </div>
</div>