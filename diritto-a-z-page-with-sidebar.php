<?php
/**
 * Template Name: Diritto A-Z with Sidebar 
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package tecnavia
 */

get_header(); ?>

    <section class="content">
        <div class="container">
            <div class="row discrpt-main">
                <div class="col-md-8">
                    <div class="analisi mrkt2 att" style="margin-bottom:10px;margin-top:0;margin-right: 6px;">
                        <div class="wrap">
                            <i class="fa fa-bookmark" aria-hidden="true"></i> 
                            <span>WHITE PAPERS</span>
                            <div class="arr-down"></div>
                        </div>  
                    </div>
                    <div class="pg-temp-cont">
                        <p>Le ultime notizie, analisi e ranking degli studi legali e tributari in 
                            Italia raccolti e coordinati dalla Redazione e dal Centro Studi TopLegal. Un osservatorio del 
                        </p>
                    </div>
                </div>
            </div>
            <div class="row diritto-list-wrap">
                <div class="col-md-9 ls">
                    <div class="analisi mrkt2 att" style="margin-bottom:10px;margin-top:0;margin-right: 6px;">
                        <div class="wrap">
                            <i class="fa fa-bookmark" aria-hidden="true"></i> 
                            <span>ULTIMI AGGIORNAMENTI</span>
                            <div class="arr-down"></div>
                        </div>  
                    </div>
                    <?php
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

                    $wp_query = new WP_Query( array(
                        'post_type'      => 'white_paper',//'diritto_az',
                        'paged' => $paged
                    ) );

                    if ($wp_query->have_posts()) {

                        while ($wp_query->have_posts()) : $wp_query->the_post();

                            get_template_part( 'template-parts/content', 'diritto-a-z-page' );

                        endwhile;

                    }

                    tecnavia_pagination();
                    
                    wp_reset_query();
                    //wp_reset_postdata();
                    ?>
                </div>
                <div class="col-md-1"></div>
				<div class="col-md-2 hidden-xs hidden-sm rs diritto-rght-sidebar">
                    <!--<ul><?php //wp_list_categories('orderby=name&show_count=1&exclude=10'); ?></ul>-->
                    <?php
                        if ( is_active_sidebar( 'diritto-a-z-sidebar' ) ) :
                            wp_reset_postdata();
                            dynamic_sidebar( 'diritto-a-z-sidebar' );
                        endif;
                    ?>
                </div>
            </div>
        </div>
    </section>
<?php
get_footer();
