<?php
/*
 * The template for displaying guida single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package tecnavia
*/



get_header(); 
?>
<?php while ( have_posts() ) : the_post(); ?>
    <?php 
    global $wp;
    $page_url =  home_url( $wp->request ); 
    global $post;
    $post_slug = $post->post_name;
    //var_dump($post_slug);
    /*---------------------------------------------------------------------------------------------*/
    $settore_ids = array();
    $arg = array(
      'post_type'        => 'guida_item',
      'posts_per_page'   => -1
    ); 
    $guida_items = new WP_Query( $arg );
    while ($guida_items->have_posts()) {
        $guida_items->the_post();
        $guida_slug = maybe_unserialize( get_post_meta( get_the_ID(), 'bind-to-guida-slug', true ) );
        if ($guida_slug == $post_slug) {
            $this_settore_id = wp_get_post_terms( get_the_ID(), 'settore', array('fields' => 'ids') );
            $settore_ids[] = $this_settore_id[0];
        }
    }
    if (count($settore_ids) == 0) {
        $settore_ids[] = 1;
    }
    //var_dump($settore_ids);
    wp_reset_postdata();
    /*---------------------------------------------------------------------------------------------*/
    $parent_sectors_name ='';
    if ( isset( $_GET['type'] ) ) {
        $parent_sectors_name = $_GET['type'];
        $parent_sectors = get_term_by('name', $parent_sectors_name, 'settore');
        $sectors = get_terms( 'settore', array(
            'parent' => $parent_sectors->term_id,
            'include' =>$settore_ids
         ));
    } else {
        $sectors = get_terms( 'settore', array(
            'include' =>$settore_ids
         ));
    }
    //var_dump($sectors);
    $c_terms = array();
    if( $sectors && ! is_wp_error($sectors) ) {
       foreach ( $sectors as $term ) {
           $c_terms[$term->slug] = $term->name;
       }
    }

    //var_dump($sectors);
    $ranks = get_terms( 'ranking', array(
                                        'orderby'  => 'slug',
                                        'order'   => 'ASC'
                                    ));
    //var_dump($ranks);
    ?>
    <?php if (!isset($_GET['settore'])): $sectors = array_unique($c_terms); ?>
    <section id="single-guida" class="content guida-page">
        <div class="container">
            <div class="" style="height: 80px;">
            </div>
            <div class="row">
                <div class="col-md-2 left-column contatti">
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
                <div class="col-md-6 left-column content">
                   <div class="guida-title">
                        <div class="title">
                            <div class="name">
                                <h4>Scenario <?php the_title(); ?></h4>
                            </div>
                        </div>
                   </div>
                   <div class="guida-content">
                        <?php the_content(); ?>
                   </div>
                </div><!--end col-md-6-->
                <div class="col-md-4 right-column">
                    <div id="linearanking"></div>
                       <div class="right-guida-title">
                            <div class="title">
                                <h4><?php the_title(); ?></h4>
                            </div>
                       </div>
                    <div class="setore-items">
                        <p>I migliori studi e professionisti</p>
                        <span>Link alle classifiche </span>
                        <ul>
                        <?php foreach( $sectors as $slug => $settore ): ?>
                        <li><a id="<?php echo $slug; ?>" href="<?php echo $page_url; ?>/?type=studio&settore=<?php echo $slug; ?>"><span><?php echo $settore; ?></span></a></li>
                        <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php if ( has_post_thumbnail() ) : ?>
                    <div class="guida-thumbnail"><?php print tecnavia_get_post_image( array( 345, 'auto' ), 'img-responsive' ); ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <?php //endwhile; // End of the loop. 
            //wp_reset_postdata();
            ?>
        </div>
    </section>
    <?php elseif (isset($_GET['settore'])): $settore_slug = $_GET['settore']; ?>
    <section class="content guida-page guida-items-list">
        <div class="container" style="position: relative;">
            <div class="" style="height: 80px;"></div>
            <div class='row'>
                <div class="container">
                    <div class="guida-title">
                        <div class="title">
                            <div class="name">
                                <h4><?php the_title(); ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="pg-temp-cont">
                        <p>Dall’osservatorio TopLegal, chiavi di lettura e opinioni su studi legali, direzioni di società e il mercato italiano ed estero</p>
                    </div>
                </div>
            </div>
            <div class="row" style="height: 50px;"></div>
            <div class="row letters-rule-system">
                <?php
                    $post_type='';
                    $post_type = $_GET['type'];
                //echo $post_type;
                ?>
                <div class="col-md-7">
                    <?php 
                    if (strpos($settore_slug, 'professionista') == false) {
                        $settore_slug_prof = $settore_slug.'-professionista';
                    } else  { 
                        $settore_slug_prof = $settore_slug;
                        $settore_slug = str_replace('-professionista',"", $settore_slug); 
                    }
                    ?>
                    <?php if( $post_type == 'studio' ): ?>
                    <div class="tnnt btn active" post-type="company" 
                                                id="guida-studi-btn"><a href="<?php echo $page_url; ?>/?type=studio&settore=<?php echo $settore_slug; ?>">Studi</a></div>
                    <div class="tnnt btn" post-type="professionist" 
                                                id="tutti-prof"><a href="<?php echo $page_url; ?>/?type=professionista&settore=<?php echo $settore_slug_prof; ?>">Professionisti</a></div>
                    <?php elseif ( $post_type == 'professionista' ): ?>
                    <div class="tnnt btn" post-type="company" 
                                                id="guida-prof-btn"><a href="<?php echo $page_url; ?>/?type=studio&settore=<?php echo $settore_slug; ?>">Studi</a></div>
                    <div class="tnnt btn active" post-type="professionist" 
                                                id="tutti-prof"><a href="<?php echo $page_url; ?>/?type=professionista&settore=<?php echo $settore_slug_prof; ?>">Professionisti</a></div>
                    <?php endif; ?>
                </div>
                <div class="col-md-5 sectors-select">
                    <div class="setore-items">
                        <?php
                        $_parent_sectors = get_term_by('name', $parent_sectors_name, 'settore');
                        $_sector = get_terms( 'settore', array(
                            'parent' => $_parent_sectors->term_id,
                            'slug' => $_GET['settore']
                         ));
                        ?>
                        <div id="current-setture-guide-items">
                            <div class="col-md-11">
                            <?php     
                                if( $_sector && ! is_wp_error($_sector) ) {
                                   foreach ( $_sector as $term ) {
                                       echo $term->name;
                                   }
                                } 
                            ?>
                            </div>
                            <div class="col-md-1 icftn"><i class="fa fa-sort-desc" aria-hidden="true"></i><i class="fa fa-times" aria-hidden="true" style="diplay: none;"></i></div>
                        </div>
                    </div>
                </div>
                <div id="settories-list">
                    <ul>
                    <?php foreach( $sectors as $settore ): ?>
                    <li><a id="<?php echo $settore->slug; ?>" href="<?php echo $page_url; ?>/?type=<?php echo $post_type; ?>&settore=<?php echo $settore->slug; ?>"><span><?php echo $settore->name; ?></span></a></li>
                    <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="container" style="height: 50px;">Tutti i dati provvengono da indagini sui clienti. <a href="" style="color: #0c71bd;" >Vedi le indicazioni sulla nostra metodologia </a></div>
            <div class="row">
                <div class="container right-column guida-items-group-of-settire">
                    <div class="setore-items" style="overflow: hidden;">
                        <?php 
                        $itr = 0;
                        foreach ($ranks as $rank): 
                            $rankname =  explode(' ' , $rank->name); 
                            //var_dump($rankname);
                            if (preg_match('/^([\d]+)([a-z])$/', $rankname[0])) {
                                    $rankname = $rankname[1].' '.substr($rankname[0], 0,1);
                            }  
                            else $rankname = $rank->name;
                            $arg = array(
                              'post_type'        => 'guida_item',
                              'posts_per_page'   => -1,
                              
                              'meta_key'         =>  'bind-to-guida-slug',
                              'meta_value'       =>   $post_slug,
                              'settore'    => $_GET['settore'],
                              'ranking'    => $rank->slug,
                              'order'      => 'ASC',
                              'orderby' => array( 'name' => 'ASC' )
                            ); 
                            $query = new WP_Query( $arg );
                            $data = $query->posts; 
                            //var_dump($data);
                        ?>
                        <?php if (count($data) > 0):  $itr++;?>
                        <div class="col-md-3">
                            <h4><?php echo $rankname; ?></h4>
                            <ul>
                                <?php 
                                    foreach ($data as $item): 
                                        $directory = maybe_unserialize( get_post_meta( $item->ID, 'guida-items-directory', true ) );
                                        //$extrn_id  = maybe_unserialize( get_post_meta( $item->ID, 'guida-items-external-id', true ) );
                                        $extrn_name_studio  = maybe_unserialize( get_post_meta( $item->ID, 'guida-items-external-id', true ) );
                                        $extrn_id_studio  = maybe_unserialize( get_post_meta( $item->ID, 'guida-items-external-id-hidden', true ) );
                                        $extrn_name_professionista  = maybe_unserialize( get_post_meta( $item->ID, 'guida-items-external-id-professionista', true ) );
                                        $extrn_id_professionista  = maybe_unserialize( get_post_meta( $item->ID, 'guida-items-external-id-professionista-hidden', true ) );
                                ?>
                                        <?php if ( $parent_sectors_name == 'studio' ): ?>
                                        <li><p><a id="<?php echo $extrn_id_studio; ?>" class="span_testodatisettore14" href="<?php echo get_post_permalink( $item->ID ); ?>?type=studio"><?php echo $item->post_title; ?></a></p>
                                            <i class="fa fa-chevron-right" aria-hidden="true"></i></li>
                                        <?php elseif ( $parent_sectors_name == 'professionista' ): ?>
                                        <li><p><a id="<?php echo $extrn_id_professionista; ?>" class="span_testodatisettore14" href="<?php echo get_post_permalink( $item->ID ); ?>?type=professionista"><?php echo $item->post_title; ?></a></p>
                                        <a href="#" id="<?php echo  $extrn_id_studio; ?>"><?php echo $extrn_name_studio;?></a>
                                        <i class="fa fa-chevron-right" aria-hidden="true"></i></li>
                                        <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php if ( $itr%4 == 0 ): ?>
                        <div class="col-md-12" style="height: 15px;"></div>
                        <?php endif; ?>
                        <?php endif; endforeach; ?>
                   </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; //end check $_GET['settore'] ?>
<?php endwhile; // End of the loop. 
wp_reset_postdata();
?>
<?php
get_footer('guida');