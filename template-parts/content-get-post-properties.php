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

?>
	<!--<div class="ite visible-xs">-->
	<div class="wapics-img">
        <div class="name">
        	<?php if (!empty($occhiello)) : ?>
                <h4 class="occhiello"><span><?php echo $occhiello; ?></span></h4>
            <?php endif; ?>
            <h4><?php echo $title; ?></h4>
            <?php if (!empty($excerpt)) {?>
            <div class="excerpt-single"><?php echo tecnavia_get_excerpt($excerpt, 60); ?></div>
            <?php } ?>
        </div>
        <div class="right-news hidden-xs">
            <?php print  $GLOBALS['background']; ?>
        </div>
        <div class="ite visible-xs">
            <div class="right-news">
                <?php print tecnavia_get_post_image( array( 345, 'auto' ), 'img-responsive' ); ?>
            </div>
        </div>
    </div>