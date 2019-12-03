<?php
/**
 * The template part for displaying single posts
 *
 * @package WordPress
 * @subpackage Tecnavia
 * @since Tecnavia 1.0
 */


$occhiello =  get_post_meta(get_the_ID(), 'post_occhiello', true);
$title = get_the_title();
$catenaccio =  get_post_meta(get_the_ID(), 'post_catenaccio', true);
$excerpt = get_the_excerpt();
$content = get_the_content();

$prevPost = tecnavia_get_adjacent_post( true, false );
$prevPostJS = null;

if ($prevPost instanceof WP_Post) {
	$prevPostJS = array(
		'title' => get_the_title($prevPost->ID),
		'link' => get_permalink($prevPost->ID)
	);
}

$nextPost = tecnavia_get_adjacent_post( true, true );
$nextPostJS = null;

if ($nextPost instanceof WP_Post) {
	$nextPostJS = array(
		'title' => get_the_title($nextPost->ID),
		'link' => get_permalink($nextPost->ID)
	);
}



?>
<script type="text/javascript">

	var IS_SINGLE_PAGE = true;

   
    var PREV_LINK = <?php print json_encode($prevPostJS);?>;
    var NEXT_LINK = <?php print json_encode($nextPostJS);?>;
    
    
</script>
<article id="post-<?php the_ID(); ?>" <?php post_class('block'); ?>>
    <span class="date visible-xs"><?php
		if ( get_post_type( get_the_ID() ) == 'event' ) {
			echo get_post_meta( get_the_ID(), 'event_from', true).' -- '.get_post_meta( get_the_ID(), 'event_till', true);
		}else {
			tecnavia_posted_on();
		} ?></span>
    <?php if (empty($occhiello)) {?>
			<h1 class="title-single-post"><?php the_title(); ?></h1>
	<?php } else { ?>
			<h4 class="occhiello"><?php echo $occhiello; ?></h4>
			<h1 class="title-single-post"><?php the_title(); ?></h1>
	<?php } ?>
	
	<?php if (!empty($catenaccio)) { ?>
			<div class="catenaccio-single"><?php echo $catenaccio; ?></div>
	<?php } ?>	
    <div class="mrkt-chld">
        <div class="pull-left"><i class="fa fa-bookmark" aria-hidden="true"></i> <?php
			if ( get_post_type( get_the_ID() ) == 'event' ) {
				print tecnavia_get_post_category( get_the_ID(), true, 'event-category' );
			}else {
				print tecnavia_get_post_category(get_the_ID());
			}?>
			<?php
				if ( get_post_type( get_the_ID() ) == 'event' ) {
					echo get_post_meta( get_the_ID(), 'event_from', true).' -- '.get_post_meta( get_the_ID(), 'event_till', true);
				}else {?>
					<div class="date"><?php the_date(); ?></div>
				<?php }
				?>
		</div>
        <div class="pull-right">
		 <?php if ( is_active_sidebar( 'sidebar-for-share' ) ) : ?>
			<div id="sidebar-for-share">
				<?php dynamic_sidebar( 'sidebar-for-share' ); ?>
			</div>
		<?php endif; ?>
		</div>
        <div style="clear: both"></div>
        <div class="arr-down"></div>
    </div>

    <p>
        <?php print tecnavia_get_post_image('big_image', 'img-responsive', '', false, false);?>
    </p>
    
    <?php if (!empty($excerpt)) {?>
    
    	<div class="excerpt-single"><?php echo $excerpt; ?></div>
    	<hr>
    	
    <?php } ?>
    
    <?php //the_content();?>
    <?php  
    	$content = get_the_content();
    	$arr = explode(' ', $content);
    	$start_cont = '';
    	$end_cont  = '';
    	$sub_arr = array();
    	for ($i=0; $i < 2; $i++) { 
    		$sub_arr[$i] = array();
    		for ($j= ($i * round(count($arr)/2)); $j < (($i + 1) * round(count($arr)/2)); $j++) { 
    			$sub_arr[$i][] = $arr[$j];
    		}
    	}
    	$start_cont = implode(' ', $sub_arr[0]);
    	$end_cont = implode(' ', $sub_arr[1]);
    	echo  wpautop( $start_cont . ' ', $br );
		if ( is_active_sidebar( 'single-post-advertising' ) ) :
			dynamic_sidebar( 'single-post-advertising' ); 
		endif;
	 	echo wpautop(' ' . $end_cont);
    ?>
</article>
