<?php
/*
Template Name: Guida Toplegal
*/



get_header(); 
?>
<section class="content archive guida-page">
    <div class="container">
        <div class="" style="height: 80px;">
        </div>
        <div class="">
            <div class="col-md-3 left-column">
                <div class="title contattaci">
                    <div class="name">
                        <h4>Contatti</h4>
                    </div>
                </div>
                <div class="academy">
                    <div class="title">
                        <div class="name">
                            <h4>Responsable riceche</h4>
                        </div>
                    </div>
                </div>
                <p id="name">Nuova risorsa</p>
                <p id="phone">02.87084121</p>
                <p id="email">mmarketing@toplegal.it</p>
            </div>
            <div class="col-md-9 guida-list">
                <?php
                global $wp_query;
                $paged = (get_query_var( 'paged' )) ? absint( get_query_var( 'paged' ) ) : 1;
                $posts_per_page = get_option( 'posts_per_page' );
                    $months = array(
                        'gennaio', 
                        'febbraio',
                        'marzo',
                        'aprile',
                        'maggio',
                        'giugno',
                        'luglio',
                        'agosto',
                        'settembre',
                        'ottobre',
                        'novembre',
                        'dicembre'
                        );
                    $arg = array(
                      'post_type'        => 'guida',
                      'posts_per_page'   => -1,
                      'posts_per_page' => $posts_per_page,
                      'paged'          => $paged
                    ); 
                    $wp_query = new WP_Query( $arg );
                    $wp_query->max_num_pages = ceil ( $wp_query->found_posts/($posts_per_page) );
                    if ( $wp_query->have_posts() ):
                    while ( $wp_query->have_posts() ) : $wp_query->the_post(); 
                        $manth = maybe_unserialize( get_post_meta( get_the_ID(), 'guida-month', true ) );
                        $year = maybe_unserialize( get_post_meta( get_the_ID(), 'guida-year', true ) );
                ?>
                <div class="row">
                    <div class="col-md-4">
                       <div class="guida-title">
                            <div class="title guida-title">
                                <div class="name">
                                    <h4><a href="<?php print esc_url( get_permalink() ); ?>"><?php the_title(); ?></a></h4>
                                </div>
                            </div>
                            <div class="title guida-date">
                                <div class="name">
                                    <h4><?php echo $months[$manth].' '.$year; ?></h4>
                                </div>
                           </div>
                       </div>
                    </div>
                    <div class="col-md-6"><?php $content = get_the_content(); echo substr($content, 0, 345); if (strlen($content) > 345 ) {
                        echo '...';
                    }?></div>
                    <div class="col-md-2"><?php print tecnavia_get_post_image( array( 345, 'auto' ), 'img-responsive' ); ?></div>
                </div>
                <?php 
                    endwhile; 
                    endif;
                    tecnavia_pagination();
                    wp_reset_postdata();
                ?>
            </div><!--end col-md-8 guida-list-->
        </div>
    </div>
</section>
<?php
get_footer('guida');