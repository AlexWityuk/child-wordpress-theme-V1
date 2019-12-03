<?php
/*
Template Name: json API Directory Studi Full no Sidebar 
*/


get_header(); 
?>
<section class="content">
    <div class="container">
    	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
    	get_template_part( 'template-parts/content', 'page-title' );
		endwhile; endif; ?>
        <?php
        global $wp;
        $page_url =  home_url( $wp->request );
        $alphabet = array( 'A', 'B', 'C', 'D', 'E', 'F', 'G', 
                           'H', 'I', 'J', 'K', 'L', 'M', 'N', 
                           'O', 'P', 'Q', 'R', 'S', 'T', 'U', 
                           'V', 'W', 'X', 'Y', 'Z');
        ?>
        <br><br>
        <?php
        $post_type='';
        $curl_url = '';
        if ( isset( $_GET['type'] ) ) {
            $post_type = $_GET['type'];
        } else $post_type = 'studio';
        //echo $post_type;
        ?>
        <div class="letters-rule-system">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-7">
                            <?php if( $post_type == 'studio' ): $curl_url = "http://82.220.53.74:3000/api/toplegal/contacts?type[]=societa&type[]=".$post_type; ?>
                            <div class="tnnt btn active" post-type="company" 
                                                        id="tutti-studi"><a href="<?php echo $page_url.'/?type=studio'; ?>">TUTTI GLI STUDI</a></div>
                            <div class="tnnt btn" post-type="professionist" 
                                                        id="tutti-prof"><a href="<?php echo $page_url.'/?type=professionista'; ?>">TUTTI I PROFESSIONISTI</a></div>
                            <?php elseif ( $post_type == 'professionista' ): $curl_url = "http://82.220.53.74:3000/api/toplegal/contacts?type[]=".$post_type; ?>
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
        
        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        // $output contains the output string
        $output = json_decode(curl_exec($ch),true);
        
        // close curl resource to free up system resources
        curl_close($ch);
        
        if (count($output) > 0) {
        
            foreach ($alphabet as $val) {
                $arr_list[$val] = array();
                foreach ($output as $post) {
                    $lit = substr($post["name"], 0, 1);
                    if ($lit == $val) {
                        $arr_list[$val][] = $post;//$post["name"] .'**$$**' . 'company';
                    }
                }
                asort($arr_list[$val]);
            }
        
        }
        
       
        
        /*
            $args = array(
                'post_type'   => 'company',
                'numberposts' => -1,
            );
             
            $posts = get_posts( $args );
            
        
            
        
            $arr_list = array();
            foreach ($alphabet as $val) {
                $arr_list[$val] = array();
                foreach ($posts as $post) {
                    $lit = substr($post->post_title, 0, 1);
                    if ($lit == $val) {
                        $arr_list[$val][] = $post->post_title .'**$$**' . 'company';
                    }
                } 
                asort($arr_list[$val]);
            }
            wp_reset_postdata();
        */
        // create curl resource
        /*--------------------------------------------------------------------------------------------------------*/
        /*$ch = curl_init();
        
        // set url
        curl_setopt($ch, CURLOPT_URL, "http://82.220.53.74:3000/api/toplegal/contacts?type=professionista");
        
        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        // $output contains the output string
        $output = json_decode(curl_exec($ch),true);
        
        // close curl resource to free up system resources
        curl_close($ch);
        
        if (count($output) > 0) {
            
            foreach ($alphabet as $val) {
                
                foreach ($output as $post) {
                    $lit = substr($post["name"], 0, 1);
                    if ($lit == $val) {
                        $arr_list[$val][] = $post;//$post["name"] .'**$$**' . 'professionist';
                    }
                }
                asort($arr_list[$val]);
            }
            
        }*/
       /*---------------------------------------------------------------------------------------------------------------------*/
        /*
            $args = array(
                'post_type'   => 'professionist',
                'numberposts' => -1,
            );
             
            $posts = get_posts( $args );
         
            foreach ($alphabet as $val) {
                foreach ($posts as $post) {
                    $lit = substr($post->post_title, 0, 1);
                    if ($lit == $val) {
                        $arr_list[$val][] = $post->post_title .'**$$**'.'professionist';
                    }
                } 
                asort($arr_list[$val]);
            }
            wp_reset_postdata();
              */
        ?>
        <?php $itr = 0;?>
        <?php foreach ($arr_list as $key => $value): ?>
        <?php if (count($value) > 0): ?>

                <div id="<?php echo $key; ?>" class="sctn active">

                <span class="btn numLttrs"><?php echo $key; ?></span>
                <?php 
                    $split = (int)(count($value) / 2);
                
                    foreach ($value as $val): $itr++;
                   
                    if ($itr == $split ) {
                        if ( is_active_sidebar( 'directory-studi-sidebar' ) ) :
                            dynamic_sidebar( 'directory-studi-sidebar' );
                        endif;
                    }
                    if ($val["type"] == 'studio'): 
                ?>
                    <div class="filterDiv company active"><a  href="" id="<?php echo $val["id"]; ?>"><?php echo $val["name"] ; ?></a></div>

                <?php elseif($val["type"]  == 'professionista'): ?>
                    <div class="filterDiv professionist active"><a  href="" id="<?php echo $val["id"]; ?>"><?php echo $val["name"] ; ?></a></div>
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
<?php
get_footer();