<?php
/*
Template Name: Homepage Analisi Full no Sidebar 
*/



get_header(); 
?>
<section class="content">
        <div class="container">
        	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
        	get_template_part( 'template-parts/content', 'page-title' );
			endwhile; endif; ?>
	 		 <?php if ( is_active_sidebar( 'editoria_analisi_page_sidebar' ) ) : ?>
	                <?php dynamic_sidebar( 'editoria_analisi_page_sidebar' ); ?>
             <?php endif; ?>
  	 		 <?php if ( is_active_sidebar( 'bottom_page_sidebar' ) ) : ?>
	                <?php dynamic_sidebar( 'bottom_page_sidebar' ); ?>
             <?php endif; ?>
        </div>
    </section>
<?php
get_footer();