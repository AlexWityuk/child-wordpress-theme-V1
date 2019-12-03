<?php
/**
 * The template for displaying the footer for guida and guida items single pages
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package tecnavia
 */
?>
<section class="footer-guida content">
    <div class="container">
    	<div class="f-wrap">
	        <div class="col-md-4">
                <?php if ( is_active_sidebar( 'guida-footer-sidebar-1' ) ) : ?>
                    <?php dynamic_sidebar( 'guida-footer-sidebar-1' ); ?>
                <?php endif; ?>
	        </div>
	        <div class="col-md-4">
                <?php if ( is_active_sidebar( 'guida-footer-sidebar-2' ) ) : ?>
                    <?php dynamic_sidebar( 'guida-footer-sidebar-2' ); ?>
                <?php endif; ?>
	        </div>
	        <div class="col-md-4">
                <?php if ( is_active_sidebar( 'guida-footer-sidebar-3' ) ) : ?>
                    <?php dynamic_sidebar( 'guida-footer-sidebar-3' ); ?>
                <?php endif; ?>
	        </div>
    	</div>
    </div>
</section>
<?php wp_footer(); ?>