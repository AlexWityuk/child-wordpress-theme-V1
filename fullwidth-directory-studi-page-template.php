<?php
/*
Template Name: Directory Studi Full no Sidebar 
*/



get_header(); 
?>
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
        <div class="letters-rule-system" id="tutti-studi">
            <div class="tnnt btn active" post-type="company">TUTTI GLI STUDI</div>
            <ul class="abc">
                <?php foreach ($alphabet as $val): ?>
                <i class="btn"><span section="<?php echo $val; ?>" post-type="company"><?php echo $val; ?></span></i>
                <?php endforeach; ?>
            </ul>
        </div>
        <div><br><br><br></div>
        <div class="letters-rule-system" id="tutti-prof">
            <div class="tnnt btn active" post-type="professionist">TUTTI I PROFESSIONISTI</div>
            <ul class="abc">
                <?php foreach ($alphabet as $val): ?>
                <i class="btn"><span section="<?php echo $val; ?>" post-type="professionist"><?php echo $val; ?></span></i>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <div class="container cmp-list-wrap">
        <div id="4" class="sctn">
            <span class="btn numLttrs">4</span>
            <div class="filterDiv">4Legal</div>
        </div>
        <?php
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
        ?>
        <?php $itr = 0; ?>
        <?php foreach ($arr_list as $key => $value): ?>
        <?php if (count($value) > 0): ?>
            <div id="<?php echo $key; ?>" class="sctn">
                <span class="btn numLttrs"><?php echo $key; ?></span>
                <?php foreach ($value as $val): $itr++;
                    $ar = explode('**$$**', $val);
                    if ($itr == 165 ) {
                        if ( is_active_sidebar( 'directory-studi-sidebar' ) ) :
                            dynamic_sidebar( 'directory-studi-sidebar' );
                        endif;
                    }
                    if ($ar[1] == 'company'): 
                ?>
                    <div class="filterDiv company"><?php echo $ar[0]; ?></div>
                <?php elseif($ar[1] == 'professionist'): ?>
                    <div class="filterDiv professionist"><?php echo $ar[0]; ?></div>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>  
        <?php endforeach;?>
        <?php /*if ( is_active_sidebar( 'directory-studi-sidebar' ) ) : ?>
            <?php dynamic_sidebar( 'directory-studi-sidebar' ); ?>
        <?php endif;*/ ?>
    </div>
</section>
<?php
get_footer();