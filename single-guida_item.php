<?php
/*
 * The template for displaying guida_item single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package tecnavia
*/



get_header(); 
?>
<section class="content guida-page guida-items-list">
    <div class="container">
		<?php 
            function get_rank_name ($rank_name) {
                $rankname =  explode(' ' , $rank_name); 
                //var_dump($rankname);
                if (preg_match('/^([\d]+)([a-z])$/', $rankname[0])) {
                        $rankname = $rankname[1].' '.substr($rankname[0], 0,1);
                }  
                else $rankname = $rank_name;
                return $rankname;
            }
        $post_type = $_GET['type'];
        while ( have_posts() ) : the_post(); 
            $this_link = get_the_permalink ( get_the_ID(), $leavename );
            $this_ID = get_the_ID();
            $directory = maybe_unserialize( get_post_meta( get_the_ID(), 'guida-items-directory', true ) );
            //var_dump(get_the_ID(),$extrn_id_studio); echo "<br/>";
            //var_dump($extrn_id_professionista);
            /*---------------------------------------------------------------------------------------------*/
            $guida_settore = array();
            $settoe_ids_ranking = array();
            $external_meta_key = '';
            if ($directory == 'studio') {
                $external_meta_key = 'guida-items-external-id-hidden';
            }
            elseif ($directory == 'professionista') {
                $external_meta_key = 'guida-items-external-id-professionista-hidden';
            }
            $extrn_id  = maybe_unserialize( get_post_meta( get_the_ID(), $external_meta_key, true ) );
            if ($extrn_id != '') {
                $arg = array(
                    'post_type'        => 'guida_item',
                    'posts_per_page'   => -1,
                    'meta_query'       => array(
                                array(
                                    'key'     => $external_meta_key,
                                    'value'   => $extrn_id
                                )
                            )
                );
                $guida_items = new WP_Query( $arg );
                while ($guida_items->have_posts()) {
                    $guida_items->the_post();
                    $directory = maybe_unserialize( get_post_meta( get_the_ID(), 'guida-items-directory', true ) );

                    $guida_slug = maybe_unserialize( get_post_meta( get_the_ID(), 'bind-to-guida-slug', true ) );

                    $this_settore_id = wp_get_post_terms( get_the_ID(), 'settore', array('fields' => 'ids') );
                    //var_dump($this_settore_id);

                    $this_ranking = get_the_terms( get_the_ID(), 'ranking' );

                    if ($post_type == $directory) {

                        //$guida_settore[$post_type][$guida_slug][] = $this_settore_id[0];
                        //$rankname = get_rank_name ($this_ranking[0]->name);
                        //$settore_ids_ranking[$post_type][$guida_slug][] = $rankname;

                        for ($i=0; $i < count($this_settore_id) ; $i++) { 
                            $guida_settore[$post_type][$guida_slug][] = $this_settore_id[$i];
                            $rankname = get_rank_name ($this_ranking[0]->name);
                            $settore_ids_ranking[$post_type][$guida_slug][] = $rankname;
                        }
                
                    }

                }
                wp_reset_postdata();
            }
            //var_dump($guida_settore); echo '<br/>***************<br/>';
            //var_dump($guida_slugs);

            //var_dump($settore_ids_ranking); echo '<br/>***************<br/>';
            //var_dump($guida_settore);
            /*---------------------------------------------------------------------------------------------*/
        ?>
        <div class="" style="height: 80px;"></div>
        <div class="row">
            <div class="col-md-2 left-column">
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
            <div class="col-md-5 letters-rule-system">
	            <div class="guida-title">
	                <div class="title">
	                    <div class="name">
	                        <h4><?php the_title(); ?></h4>
	                    </div>
	                </div>
	            </div>
                <?php if( $post_type == 'studio' ): ?>
                	<div class="tnnt btn active" post-type="professionist" 
                                                id="tutti-prof"><a href="<?php echo $this_link; ?>/?type=studio">Classifiche Studio</a></div>
                    <div class="tnnt btn" post-type="professionist" 
                                                id="tutti-prof"><a href="<?php echo $this_link; ?>/?type=professionista">Classifica professionisti</a></div>
                    <!--<div class="tnnt btn" post-type="company" 
                                                id="guida-studi-btn"><a href="<?php echo $this_link; ?>">Analisi TopLegal</a></div>-->
                <?php elseif ( $post_type == 'professionista' ): ?>
                    <div class="tnnt btn" post-type="professionist" 
                                                id="tutti-prof"><a href="<?php echo $this_link; ?>/?type=studio">Classifiche Studio</a></div>
                    <div class="tnnt btn active" post-type="professionist" 
                                                id="tutti-prof"><a href="<?php echo $this_link; ?>/?type=professionista">Classifica professionisti</a></div>
                    <!--<div class="tnnt btn" post-type="company" 
                                                id="guida-studi-btn"><a href="<?php echo $this_link; ?>">Analisi TopLegal</a></div>-->
                <?php endif; ?>
                <div>
                    <?php foreach ($guida_settore[$post_type] as $guida_slug => $sectors): ?>
                	<div class="right-guida-title">
                        <div class="title">
                            <h4>
                            	<?php
                            	$args = array(
								  'name'        => $guida_slug,
								  'post_type'   => 'guida',
								  'post_status' => 'publish',
								  'numberposts' => 1
								);
								$my_posts = get_posts($args);
                                //var_dump($my_posts[0]->ID);
								if( $my_posts ) :
							         echo $my_posts[0]->post_title;
									//var_dump($my_posts);
								endif; 
                            	?>
                            </h4>
                        </div>
                    </div>
                    <div class="setore-items">
                        <ul>
                          <?php $itr = 0;?>
                        <?php foreach ($sectors as $settore_id): ?>
                        <?php
                            $settore = get_terms( 'settore', array(
                                'include' => $settore_id,
                                'order'         => 'DESC'
                             ));
                            //var_dump($settore);
                        ?>
                        <?php if (preg_match('/-professionista/', $settore[0]->slug) && $post_type == 'professionista' ): ?>
                            <li setid="<?php echo $settore[0]->term_id; ?>"><a href="<?php echo get_post_permalink( $my_posts[0]->ID ); ?>?type=professionista&settore=<?php echo $settore[0]->slug; ?>">
                                <span><?php echo $settore[0]->name; ?></span></a><span class="ranking"><?php echo $settore_ids_ranking[$post_type][$guida_slug][$itr]; ?></span></li>
                            <?php elseif (!preg_match('/-professionista/', $settore[0]->slug) && $post_type == 'studio'): ?>
                            <li setid="<?php echo $settore[0]->term_id; ?>"><a href="<?php echo get_post_permalink( $my_posts[0]->ID ); ?>?type=studio&settore=<?php echo $settore[0]->slug; ?>">
                                <span><?php echo $settore[0]->name; ?></span></a><span class="ranking"><?php echo $settore_ids_ranking[$post_type][$guida_slug][$itr]; ?></span></li>
                            <?php endif; $itr++; ?>
                        <?php endforeach; ?>
                        </ul>
                    </div>
                   <?php endforeach; ?>
               </div>
            </div>
            <div class="col-md-5 content">
				<div><?php the_content(); ?></div>
			</div>
		</div>
		<?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
	</div>
</section>
<?php
get_footer('guida');