<?php
/**
 * The template part for displaying single diritto-a-z posts
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

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('block'); ?>>
	
	<h1 class="title-single-post"><?php the_title(); ?></h1>
	
	<?php if (!empty($catenaccio)) { ?>
			<div class="catenaccio-single"><?php echo $catenaccio; ?></div>
	<?php } ?>	
    
    <?php  
    	echo $content;
    ?>
</article>
