<?php
/*
Template Name: json API Directory Studi Full no Sidebar 
*/


get_header(); 

global $wp;
$page_url =  home_url( $wp->request );

$post_type='';
$curl_url = '';
if ( isset( $_GET['type'] ) ) {
    $post_type = $_GET['type'];
} else $post_type = 'studio';
//echo $post_type;
?>
<?php
//add_action( 'wp_ajax_my_action', 'toplegal_website_child_my_action' );
//add_action( 'wp_ajax_nopriv_my_action', 'toplegal_website_child_my_action' );

function toplegal_get_binded_posts($itemid) {
                $string = '';
    if (isset($itemid)) {
        $current_url = home_url( $wp->request );
        $ch = curl_init();
        
        // set url
        //curl_setopt($ch, CURLOPT_URL, "http://82.220.53.74:3000/api/toplegal/contacts/" . $_POST["itemid"]); //old url
        curl_setopt($ch, CURLOPT_URL, "https://crm.newsmemory.com:8143/api/toplegal/contacts/".urlencode($itemid));

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJjbGllbnRfYXBwIjoidG9wbGVnYWxfd29yZHByZXNzIn0.4pZlmokVU3P5J1I415a9OUR1oE2w8PhZRiB7O1dmH-k'
        ));
        
        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        //echo $output;
        // $output contains the output string
        $output = json_decode($output,true);
        
        // close curl resource to free up system resources
        curl_close($ch);

        if (count($output) > 0) {
            
            if (array_key_exists("post_slugs", $output) && $output["post_slugs"] > 0) {
            
            $string = $string.'<ul class="newsCorrelateList">';
            
            $relatedPosts = array();
            
            //print_r($output);
            
            foreach  ($output["post_slugs"] as $slug) {
                
                $post_ids = get_posts(array
                    (
                        'name'   => $slug,
                        'post_type'   => "post",
                        'posts_per_page' => 1
                        
                    ));
                
              $relatedPosts[] =  $post_ids;
                
            }
            
            
            foreach ($relatedPosts as $post) {
                $_post = $post[0];
                $string = $string.'<li>
                <span>'.$_post->post_title.'</span>
                <a class="fancybox fancybox.iframe  post"  data-fancybox-type="iframe"  href="'. get_permalink($_post->ID).'?overlay=1">Leggi ></a>
                </li>';   
            }  
            $string = $string.'</ul>';
            }   
        } 
    }
    return $string;
}
?>
<?php if (!isset($_GET['id'])): ?>
<section class="content">
    <div class="container">
    	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
    	get_template_part( 'template-parts/content', 'page-title' );
		endwhile; endif; ?>
        <?php
        $alphabet = array( 'A', 'B', 'C', 'D', 'E', 'F', 'G', 
                           'H', 'I', 'J', 'K', 'L', 'M', 'N', 
                           'O', 'P', 'Q', 'R', 'S', 'T', 'U', 
                           'V', 'W', 'X', 'Y', 'Z');
        ?>
        <br><br>
        <div class="letters-rule-system">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-7">
                            <?php if( $post_type == 'studio' ): $curl_url = "https://crm.newsmemory.com:8143/api/toplegal/contacts?type[]=societa&type[]=".$post_type; ?>
                            <div class="tnnt btn active" post-type="company" 
                                                        id="tutti-studi"><a href="<?php echo $page_url.'/?type=studio'; ?>">TUTTI GLI STUDI</a></div>
                            <div class="tnnt btn" post-type="professionist" 
                                                        id="tutti-prof"><a href="<?php echo $page_url.'/?type=professionista'; ?>">TUTTI I PROFESSIONISTI</a></div>
                            <?php elseif ( $post_type == 'professionista' ): $curl_url = "https://crm.newsmemory.com:8143/api/toplegal/contacts?type[]=".$post_type; ?>
                            <div class="tnnt btn" post-type="company" 
                                                        id="tutti-studi"><a href="<?php echo $page_url.'/?type=studio'; ?>">TUTTI GLI STUDI</a></div>
                            <div class="tnnt btn active" post-type="professionist" 
                                                        id="tutti-prof"><a href="<?php echo $page_url.'/?type=professionista'; ?>">TUTTI I PROFESSIONISTI</a></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-5">
                            <div class="search">
                                <div class="search-field">
                                    <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                                        <input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'tecnavia' ); ?>" value=""/>
                                        <div class="triangle"></div>
                                    </form>
                                </div>
                                <div class="user-search">
                                    <div class="directori-iva" ></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4"></div>
            </div>
            <ul class="abc">
                <?php foreach ($alphabet as $val): ?>
                    <i class="btn">
                        <span section="<?php echo $val; ?>"><?php echo $val; ?></span>
                    </i>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <div class="container">
        <div class="col-md-8 cmp-list-wrap">
        <?php 
        
        $obj_id = get_queried_object_id();
        $current_url = get_permalink( $obj_id );
        // create curl resource
        $ch = curl_init();
        
        // set url
        //curl_setopt($ch, CURLOPT_URL, "http://82.220.53.74:3000/api/toplegal/contacts?type=".$post_type);
        //curl_setopt($ch, CURLOPT_URL, "http://82.220.53.74:3000/api/toplegal/contacts?type[]=societa&type[]=studio");
        curl_setopt($ch, CURLOPT_URL, $curl_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJjbGllbnRfYXBwIjoidG9wbGVnYWxfd29yZHByZXNzIn0.4pZlmokVU3P5J1I415a9OUR1oE2w8PhZRiB7O1dmH-k'
        ));
        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        // $output contains the output string
        $output = json_decode(curl_exec($ch),true);
        
        // close curl resource to free up system resources
        curl_close($ch);
        $arr_list = array();
        if (count($output) > 0) {
        
            foreach ($alphabet as $val) {
                foreach ($output as $post) {
                    $lit = substr($post["name"], 0, 1);
                    if ($lit == $val) {
                        $arr_list[$val][] = $post;//$post["name"] .'**$$**' . 'company';
                    }
                }
                asort($arr_list[$val]);
            }
        
        }
        ?>
        <?php $itr = 0;?>
        <?php foreach ($arr_list as $key => $value): ?>
        <?php if (count($value) > 0): ?>

                <div id="<?php echo $key; ?>" class="sctn active">

                <span class="btn numLttrs"><?php echo $key; ?></span>
                <?php 
                
                    foreach ($value as $val): //var_dump($val);
                    if ($val["type"] == 'studio' || $val["type"] == 'societa'): 
                ?>
                    <div class="filterDiv company active"><a  href="<?php echo $page_url; ?>/?id=<?php echo $val['id']; ?>&title=<?php echo $val['name']; ?>" id="<?php echo $val["id"]; ?>"><?php echo $val["name"] ; ?></a></div>

                <?php elseif($val["type"]  == 'professionista'): ?>
                    <div class="filterDiv professionist active"><a  href="<?php echo $page_url; ?>/?id=<?php echo $val['id']; ?>&title=<?php echo $val['name']; ?>" id="<?php echo $val["id"]; ?>"><?php echo $val["name"] ; ?></a></div>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>  
        <?php endforeach;?>

        </div>
        <!--Right Sidebar-->
        <div id="directorystudi-rightcol" class="col-md-4">
            <div id="external-links" >
                <div class="content"></div>
                <div class="loader" style="height: 200px;"></div>
            </div>
        </div><!--End Right Sidebar-->
    </div>
</section>
<?php else: ?>
<section class="content guida-page es-studio">
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-10 letters-rule-system">
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                    <div style="margin-bottom:0; margin-top:0; margin-right: 6px;" class="mrkt2 att hidden-xs">
                        <div class="wrap" style="padding: 15px 0 0 0;">
                            <span style="font-size: 22px;"><?php the_title(); ?></span>
                            <div class="arr-down"></div>
                        </div>
                    </div>
                <?php endwhile; endif; ?>
                <h1 style="margin-top: 0; padding: 10px 0 10px 0;"><?php echo $_GET['title']; ?></h1>
                <div class="tnnt btn"  id="vedi-il-profilo"><a href="">Vedi il profilo</a></div>
                <div style="padding-bottom: 30px;"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 left-column" style="padding-top: 50px;">
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
            <div class="col-md-6 letters-rule-system">
                <h3>Ricerca</h3>
                <?php if( $post_type == 'studio' ): ?>
                    <div class="tnnt btn active" post-type="studio" 
                                                id="tutti-prof"><a href="<?php echo $page_url; ?>/?type=studio">Classifiche Studio</a></div>
                    <div class="tnnt btn" post-type="professionista" 
                                                id="tutti-prof"><a href="<?php echo $page_url; ?>/?type=professionista">Classifiche professionisti</a></div>
                <?php elseif ( $post_type == 'professionista' ): ?>
                    <div class="tnnt btn" post-type="studio" 
                                                id="tutti-prof"><a href="<?php echo $page_url; ?>/?type=studio">Classifiche Studio</a></div>
                    <div class="tnnt btn active" post-type="professionista" 
                                                id="tutti-prof"><a href="<?php echo $page_url; ?>/?type=professionista">Classifiche professionisti</a></div>
                <?php endif; ?>
                <div class="effettuate">Ricerche effettuate dal Centro Studi TopLegal</div>
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
                    /*---------------------------------------------------------------------------------------------*/
                    $guida_settore = array();
                    $settoe_ids_ranking = array();
                    $extrn_id = $_GET['id'];
                    if ($extrn_id != '') {
                        $arg = array(
                            'post_type'        => 'guida_item',
                            'posts_per_page'   => -1,
                            'meta_query'       => array(
                                'relation' => 'OR',
                                        array(
                                            'key'     => 'guida-items-external-id-hidden',
                                            'value'   => $extrn_id
                                        ),
                                        array(
                                            'key'     => 'guida-items-external-id-professionista-hidden',
                                            'value'   => $extrn_id
                                        )
                                    ) 
                        );
                        $guida_items = new WP_Query( $arg );
                        //var_dump($guida_items);
                        while ($guida_items->have_posts()) {
                            $guida_items->the_post();
                            $directory = maybe_unserialize( get_post_meta( get_the_ID(), 'guida-items-directory', true ) );

                            $guida_slug = maybe_unserialize( get_post_meta( get_the_ID(), 'bind-to-guida-slug', true ) );

                            $this_settore_id = wp_get_post_terms( get_the_ID(), 'settore', array('fields' => 'ids') );

                            $this_ranking = get_the_terms( get_the_ID(), 'ranking' );
                           if ($post_type == $directory) {
                                $guida_settore[$post_type][$guida_slug][] = $this_settore_id[0];

                                $rankname = get_rank_name ($this_ranking[0]->name);
                                $settore_ids_ranking[$post_type][$guida_slug][] = $rankname;
                            }

                        }
                        wp_reset_postdata();
                    }
                    /*---------------------------------------------------------------------------------------------*/
                ?>
                <?php foreach ($guida_settore[$post_type] as $guida_slug => $sectors): 
                        $guida_title = '';
                        $args = array(
                          'name'        => $guida_slug,
                          'post_type'   => 'guida',
                          'post_status' => 'publish',
                          'numberposts' => 1
                        );
                        $my_posts = get_posts($args);
                        //var_dump($my_posts[0]->ID);
                        if( $my_posts ) :
                             $guida_title =  $my_posts[0]->post_title;
                            //var_dump($my_posts);
                        endif; 
                ?>
                <div class="setore-items">
                    <ul>
                      <?php $itr = 0;?>
                    <?php foreach ($sectors as $settore_id): ?>
                    <?php
                        $settore = get_terms( 'settore', array(
                            'include' => $settore_id,
                            'order'         => 'DESC'
                         ));
                        if ((strlen($guida_title) + 2 + strlen ( $settore[0]->name )) > 54 ) {
                            $settore_name = substr($settore[0]->name, 0, (50 - strlen($guida_title) - 2)).'...'; 
                        }
                        else $settore_name = $settore[0]->name; 
                        //var_dump($settore);
                    ?>
                    <?php if (preg_match('/-professionista/', $settore[0]->slug) && $post_type == 'professionista' ): ?>
                        <li setid="<?php echo $settore[0]->term_id; ?>">
                            <span class="guida-title"><?php echo $guida_title.':'; ?></span>
                            <span><?php echo $settore_name; ?></span>
                            <span class="ranking"><?php echo $settore_ids_ranking[$post_type][$guida_slug][$itr]; ?></span>
                            <a href="<?php echo get_post_permalink( $my_posts[0]->ID ); ?>?type=professionista&settore=<?php echo $settore[0]->slug; ?>">
                                <span><?php echo 'Vedi >'; ?></span>
                            </a>
                        </li>
                        <?php elseif (!preg_match('/-professionista/', $settore[0]->slug) && $post_type == 'studio'): ?>
                        <li setid="<?php echo $settore[0]->term_id; ?>">
                            <span class="guida-title"><?php echo $guida_title.':'; ?></span>
                            <span><?php echo $settore_name; ?></span>
                            <span class="ranking"><?php echo $settore_ids_ranking[$post_type][$guida_slug][$itr]; ?></span>
                            <a href="<?php echo get_post_permalink( $my_posts[0]->ID ); ?>?type=studio&settore=<?php echo $settore[0]->slug; ?>">
                                <span><?php echo 'Vedi >'; ?></span>
                            </a>
                        </li>
                        <?php endif; $itr++; ?>
                    <?php endforeach; ?>
                    </ul>
                </div>
               <?php endforeach; ?>
            </div>
            <div class="col-md-4 content">
                <h3>Ultime notizie</h3>
                <div class="external-service-bind-posts">
                    <?php 
                    echo toplegal_get_binded_posts($_GET['id']);  
                    ?>
                </div>
                <div style="height: 30px;"></div>
                <h3>White paper<span>(Diritto A-Z)</span></h3>
                <div class="white-pipers-bind external-service-bind-posts">
                    <ul class="newsCorrelateList">
                    <?php
                        $wp_query = new WP_Query( array(
                            'post_type'      => 'white_paper',//'diritto_az',
                            'posts_per_page'   => -1,
                            'meta_query'       => array(
                                'relation' => 'OR',
                                        array(
                                            'key'     => 'guida-items-external-id-hidden',
                                            'value'   => $extrn_id
                                        ),
                                        array(
                                            'key'     => 'guida-items-external-id-professionista-hidden',
                                            'value'   => $extrn_id
                                        )
                                    ) 
                        ) );

                        if ($wp_query->have_posts()) {

                            while ($wp_query->have_posts()) : $wp_query->the_post(); 
                            $content = get_the_content();
                            ?>
                            <li>
                                <span><?php the_title(); ?></span>
                                <p><?php print tecnavia_get_excerpt($content, 120); ?></p>
                                <a href="<?php print esc_url( get_permalink() ) ?>"
                                    title="<?php the_title_attribute(); ?>">Leggi >
                                </a>
                            </li>
                            <?php
                            endwhile;
                            wp_reset_postdata();
                        }
                    ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
( function($) {
    $( document ).ready(function() {
        //console.log( "ready!" );
        function getSearchParameters() {
              var prmstr = window.location.search.substr(1);
              return prmstr != null && prmstr != "" ? transformToAssocArray(prmstr) : {};
        }

        function transformToAssocArray( prmstr ) {
            var params = {};
            var prmarr = prmstr.split("&");
            for ( var i = 0; i < prmarr.length; i++) {
                var tmparr = prmarr[i].split("=");
                params[tmparr[0]] = tmparr[1];
            }
            return params;
        }

        var params = getSearchParameters();
        params = '&id=' + params['id'] + '&title=' + params['title'];
        console.log(params);
        var studio_button = $('.guida-page.es-studio .btn[post-type="studio"] a').attr('href');
        var prof_button = $('.guida-page.es-studio .btn[post-type="professionista"] a').attr('href');
        $('.guida-page.es-studio .btn[post-type="studio"] a').attr('href', studio_button + params);
        $('.guida-page.es-studio .btn[post-type="professionista"] a').attr('href', prof_button + params);
    });
} )(jQuery);
</script>
<?php endif; ?>
<?php
get_footer();