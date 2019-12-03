<?php
/**
 * The template 404 page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package tecnavia
 */
global $wp;
$url =  home_url( $wp->request );
$postid = url_to_postid( $url );

get_header(); ?>
<?php if ( strpos( $url , 'elencoasp' ) === false ): ?>
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-8 ls">
                    <h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'tecnavia' ); ?></h1>
                    <p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'tecnavia' ); ?></p>
                </div>
				<?php get_sidebar(); ?>
            </div>
        </div>
    </section>
<?php elseif ( strpos( $url , 'elencoasp' ) !== false ): ?>
	<?php 
		//var_dump($url); 
		// create curl resource
	$arr = explode('/toplegal/news', $_SERVER[REQUEST_URI]);
		$ch = curl_init();

		// set url
		//curl_setopt($ch, CURLOPT_URL, "http://82.220.53.74:3000/api/toplegal/contacts?link=" . urlencode("http://toplegal.it/elencoasp/societa/20694/tim-spa"));
		curl_setopt($ch, CURLOPT_URL, "http://82.220.53.74:3000/api/toplegal/contacts?link=" . urlencode("http://toplegal.it".$arr[1]));
		/*curl_setopt($ch, CURLOPT_URL, "http://82.220.53.74:3000/api/toplegal/contacts?link=" . urlencode( $url ));*/

		//return the transfer as a string
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		 // $output contains the output string
    	$output = json_decode(curl_exec($ch),true);

		// close curl resource to free up system resources
		curl_close($ch);

		var_dump( $output );
		//echo get_home_url();
		echo "<br/>";
		//echo $_SERVER['REQUEST_URI'];
		$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$arr = explode('/toplegal/news', $_SERVER[REQUEST_URI]);
		echo $arr[1];
	?>
<?php endif; ?>
<?php
get_footer();