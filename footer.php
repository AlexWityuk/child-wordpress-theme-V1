<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package tecnavia
 */
?>


<?php if ( is_active_sidebar( 'sidebar-bottom-popup' ) ) : ?>
	<div id="bottom-overlay-wrap" style="display:none">
		<a href="#" id="bottom-overlay-close"><span>X</span></a>
		<div class="bottom-overlay-container">
			<?php dynamic_sidebar( 'sidebar-bottom-popup' ); ?>
		</div>
	</div>
	<script type="text/javascript">
		(function($){

			//Get cookie
			var token = cookies('sidebar_bottom_popup');
			
			if (typeof token == "undefined") {

				cookies({ sidebar_bottom_popup: 'close' }, {
				  expires: <?php echo get_theme_mod('tecnavia_sidebar_bottom_popup_expire', '5'); ?>*60,     // The time to expire in seconds
				  domain: '<?php echo $_SERVER['HTTP_HOST']; ?>'              			 
				});

				$("#bottom-overlay-wrap").show();
				
				$("#bottom-overlay-close").click(function(){

					$("#bottom-overlay-wrap").fadeOut();
					
					return false;
				});
			
			}			
			
		})(jQuery);
	</script>
<?php endif; ?>

<?php if ( is_active_sidebar( 'footer-widget-area-1' ) || is_active_sidebar( 'footer-widget-area-2' ) || is_active_sidebar( 'footer-widget-area-3' ) || is_active_sidebar( 'footer-widget-area-4' )|| is_active_sidebar( 'footer-widget-area-5' ) ) : ?>
<section class="footer content">
    <div class="container">
        <div class="row">
        	<div  class="left-container col-xs-12 col-sm-12 col-md-12">
	            <div class="col-sm-3 col-md-3">
	                <?php if ( is_active_sidebar( 'footer-widget-area-1' ) ) : ?>
	                    <?php dynamic_sidebar( 'footer-widget-area-1' ); ?>
	                <?php endif; ?>
	            </div>
	            <div class="col-sm-3 col-md-3">
	            <?php if ( is_active_sidebar( 'footer-widget-area-2' ) ) : ?>
	                <?php dynamic_sidebar( 'footer-widget-area-2' ); ?>
	            <?php endif; ?>
	            </div>
	            
	            <div class="col-sm-2 col-md-2">
	            <?php if ( is_active_sidebar( 'footer-widget-area-3' ) ) : ?>
	                <?php dynamic_sidebar( 'footer-widget-area-3' ); ?>
	            <?php endif; ?>
	            </div>
	            <div class="col-sm-2 col-md-2">
	            <?php if ( is_active_sidebar( 'footer-widget-area-4' ) ) : ?>
	                <?php dynamic_sidebar( 'footer-widget-area-4' ); ?>
	            <?php endif; ?>
	            </div>
				<div class="col-sm-2 col-md-2">
					<?php if ( is_active_sidebar( 'footer-widget-area-5' ) ) : ?>
						<?php dynamic_sidebar( 'footer-widget-area-5' ); ?>
					<?php endif; ?>
				</div>
			</div>
			<div  class="right-container col-xs-12 col-sm-12 col-md-4 no-padding-right">
			 <?php if ( is_active_sidebar( 'footer-right-sidebar' ) ) : ?>
	                <?php dynamic_sidebar( 'footer-right-sidebar' ); ?>
	            <?php endif; ?>
			</div>
        </div>
    </div>
</section>
<?php endif; ?>
<?php if ( is_active_sidebar( 'sidebar-bg-image-ads' ) ) : ?>
	<?php dynamic_sidebar( 'sidebar-bg-image-ads' ); ?>
<?php endif; ?>
<div id="modal-video" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body"><iframe width="100%" height="315" src="" frameborder="0" allowfullscreen></iframe></div>
        </div>
    </div>
</div>
<?php if (is_single()) :?>
    <script type="text/javascript">
        var currentPostId = <?php print get_the_ID();?>;
    </script>
<?php endif;?>
<script type="text/javascript">

		/*
		
		postJS:

		<?php 
		
		global $postsJS;
		global $postsJSListener;
		//print_r($postsJS);
		//print_r($postsJSListener);
		
		?>

		*/
		
		if (typeof IS_SINGLE_PAGE == "undefined") 
			localStorage.setItem("currentNav", "undefined");
			
		if (typeof IS_ARCHIEVE_PAGE != "undefined") {
			localStorage.setItem("currentNav", "category");
		}
			

		//console.log(localStorage.getItem("currentNav"));
				
		var postsLocations = <?php echo json_encode($postsJS); ?>,
			postLocationsListn = <?php echo json_encode($postsJSListener); ?>,
			loc, sing, itm, listn = [];

		var currentURL = "<?php echo (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>";
			
		for (loc in postLocationsListn) {	
					
			(function(_listn, _loc){
				
				for (var i in _listn) {
					
					jQuery(_listn[i]).click(function(){

						localStorage.setItem("currentNav", JSON.stringify(postsLocations[_loc]));
						//console.log(JSON.stringify(postsLocations[_loc]), _loc);

						
					});
					
				}
				
			})(postLocationsListn[loc], loc);		
			
		}
		
		if (jQuery("body").hasClass("single-post")) {

			if (typeof localStorage.getItem("currentNav") != "undefined") {

				prevPostLink = "";
				nextPostLink = "";

				if (localStorage.getItem("currentNav") == "category") {

				
					if (NEXT_LINK != null)
						nextPostLink = '<a href="' + NEXT_LINK["link"] + '" title="' + NEXT_LINK["title"] + '"><i class="fa fa-chevron-right"></i></a>';
					
					if (PREV_LINK != null)
						prevPostLink = '<a href="' + PREV_LINK["link"] + '" title="' + PREV_LINK["title"] + '"><i class="fa fa-chevron-left"></i></a>';
					
					
				} else {
									
					var nav = JSON.parse(localStorage.getItem("currentNav"));
					
					
					if (typeof nav[currentURL] != "undefined") {
	
						var prevURL = "",
							nextURL = "",
							found = false;
	
						
						for (var url in nav) {					
	
							if (found) {
								
								nextURL = url;
								break;
							}
							
							if (url == currentURL) {
								
								found = true;
								
							} else {
								
								prevURL = url;
								
							}
							
							
						}
						
						
	
						if (prevURL != "")
							prevPostLink = '<a href="' + prevURL + '" title="' + nav[prevURL]["title"] + '"><i class="fa fa-chevron-left"></i></a>';
	
						if (nextURL != "")
			                nextPostLink = '<a href="' + nextURL + '" title="' + nav[nextURL]["title"] + '"><i class="fa fa-chevron-right"></i></a>';
	
	
					}

				}

				jQuery('#breadcrumbs').append('<li class="current_section_menu referrer-links">' + prevPostLink + nextPostLink + '</li>');
		          
				
			}
				
		}
		
	
    </script>
<?php wp_footer(); ?>

</body>
</html>
