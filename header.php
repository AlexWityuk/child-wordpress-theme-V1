<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package tecnavia
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php wp_site_icon();?>
<?php wp_head(); ?>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body <?php body_class(); ?>>
<?php if ( is_active_sidebar( 'sidebar-is-for-the-left' ) || is_active_sidebar( 'sidebar-is-for-the-right' )  ) { ?>
	<div class="externalsidebar">
	    <div class="container hidden-xs hidden-sm">
	    	<div class="externalsidebar-container">
		        <div class="sidebar-is-for-the-left hidden-xs hidden-sm">
		            
		                <?php if ( is_active_sidebar( 'sidebar-is-for-the-left' ) ) : ?>
		                    <?php dynamic_sidebar( 'sidebar-is-for-the-left' ); ?>
		                <?php endif; ?>
		          
		        </div><!-- end div sidebar-is-for-the-left-->
		        <div class="sidebar-is-for-the-right hidden-xs hidden-sm">
		       
		                <?php if ( is_active_sidebar( 'sidebar-is-for-the-right' ) ) : ?>
		                    <?php dynamic_sidebar( 'sidebar-is-for-the-right' ); ?>
		                <?php endif; ?>
		             
		        </div><!-- end div sidebar-is-for-the-right-->
	        </div>
	    </div>
    </div>
    <script type="text/javascript">

		jQuery(function(){

			var _width = 0;
				
			
			setInterval(function(){

				
				_width = jQuery(".sidebar-is-for-the-left").outerWidth(true);
				

				jQuery(".sidebar-is-for-the-left").css("left", (-1)*_width-15);

				_width = jQuery(".sidebar-is-for-the-right").outerWidth(true);

				jQuery(".sidebar-is-for-the-right").css("right", (-1)*_width-15);
				
			},150);
			
		});
	
    </script>
<?php }
$activeNewMenu = get_theme_mod( 'tecnavia_main_menu_advanced_enable', '' );

if ($activeNewMenu) {

//if ( $_SERVER['REMOTE_ADDR'] == '188.163.96.81' ) {
	echo '<div id="tecnavia-fx-fobos" class="container--"><div id="tecnavia-fx-haze"></div><div id="tecnavia-fx-menu">';

	wp_nav_menu(array(
		'menu'              => 'Menu Main Opened',
		'menu_class'        => 'tmenu',
		'container'         => ''
	));

	echo '</div></div>';
}
?>
    <section class="header">
        <div class="container">
            <div class="banner banner-bordered text-center">
	            <?php if ( is_active_sidebar( 'header-top-widget-area' ) ) : ?>
                    <?php dynamic_sidebar( 'header-top-widget-area' ); ?>
	            <?php endif; ?>
            </div>
            <div class="header-logo-container">
                <?php if ( is_active_sidebar( 'header-left-widget-area' ) ) : ?>
                <div class="hidden-xs">
	            	<?php dynamic_sidebar( 'header-left-widget-area' ); ?>	                
                </div>
                <?php endif; ?>
                <?php if(has_custom_logo()) :?>
                <div class="text-center">
                    <a href="<?php echo esc_url(home_url('/')); ?>">
	                	<?php the_custom_logo();?>                        
                    </a>
                </div>
                <?php endif;?>
                <?php if ( is_active_sidebar( 'header-right-widget-area' ) ) : ?>
                <div class="hidden-xs">
	            	<?php dynamic_sidebar( 'header-right-widget-area' ); ?>	              
                </div> 
                 <?php endif; ?>
            </div>
        </div>
        <div class="container">
	        <div class="sidebar_between_logo_and_menu">
	            <?php if ( is_active_sidebar( 'sidebar-between_the_main_logo_and_the_menu' ) ) : ?>
	                <?php dynamic_sidebar( 'sidebar-between_the_main_logo_and_the_menu' ); ?>
	            <?php endif; ?>
	        </div>
	    </div>
        <div id="mainNav" class="container">
            <nav class="navbar navbar-default" id="navbar-default-child">
                    <div class="mobile">
                        <div class="pull-left">
                        	<?php
                        	/*
                        	<a href="<?php echo esc_url(home_url('/')); ?>" class="hm">
                        		<i class="fa fa-home " aria-hidden="true"></i>
                        	</a>
                        	*/
                        	?>
                        	<div class="bg-old">
                        		<i class="fa fa-bars" aria-hidden="true"></i>
                        		<i class="fa fa-times" aria-hidden="true"></i>
                        	</div>
                        </div>
                        <div class="pull-right">
                    		<i class="user-icon"></i>
                    		<div class="iva" href=""></div>
                        	<div class="bg-child-new">
                        		<i class="fa fa-bars" aria-hidden="true"></i>
                        		<i class="fa fa-times" aria-hidden="true"></i>
                        	</div>
                        </div>
                        <div class="pull-right">
                            <div class="search">
                                <div class="search-field">
                                    <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                                        <input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'tecnavia' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
                                        <div class="triangle"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--<div class="collapse navbar-collapse navbar-primary">-->
                	<div class="navbar-collapse navbar-primary">
	                    <ul class="navbar-nav section-nav-icons">	
	                    	<!--<li class="hidden-xs hidden-sm user-search">-->
                    		<li class="user-search">
	                    		<!--user-->
	                			<i class="user-icon"></i>
	                			<!--search-->
	                			<div class="search">
	                                <div class="iva" href=""></div>
	                                <div class="search-field">
	                                    <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	                                        <input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'tecnavia' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	                                        <div class="triangle"></div>
	                                    </form>
	                                </div>
	                            </div>
	                    	</li>
	                        <!--mbmenu-->
	                        <!--<li class="hidden-xs hidden-sm mbmenu-block">-->
                        	<li class="mbmenu-block">
	                            <div class="mbmenu-child opn-child" title="<?php esc_html_e( 'ALL SECTIONS', 'tecnavia' ); ?>"><i class="fa fa-bars fa-2x" aria-hidden="true"></i></div>
	                            <div class="mbmenu cls"><?php esc_html_e( 'Close', 'tecnavia' ); ?> <i class="fa fa-times fa-2x" aria-hidden="true"></i></div>
	                        </li>

	                    </ul>
				        <?php
				        remove_filter( 'wp_nav_menu_items', 'tecnavia_add_homeicon_to_main_navigation', 10, 2 );
				        if (has_nav_menu('primary_navigation')) :
					        wp_nav_menu(array(
						        'theme_location'    => 'primary_navigation',
						        'menu_class'        => 'nav navbar-nav meni',
						        'container'         => '',
						        'walker'            => new wp_bootstrap_navwalker()
					        ));
				        endif;
				        ?>
                        <?php
                        /*
                        <ul class="nav navbar-nav navbar-right">
                            <!--search-->
                            <li class="hidden-xs hidden-sm">
                                <div class="search">
                                    <div class="iva" href=""></div>
                                    <div class="search-field">
                                        <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                                            <input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'tecnavia' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
                                            <div class="triangle"></div>
                                        </form>
                                    </div>
                                </div>
                            </li>
                            <!--mbmenu-->
                            <li class="hidden-xs hidden-sm">
                                <div class="mbmenu opn" title="<?php esc_html_e( 'ALL SECTIONS', 'tecnavia' ); ?>"><i class="fa fa-bars fa-2x" aria-hidden="true"></i></div>
                                <div class="mbmenu cls"><?php esc_html_e( 'Close', 'tecnavia' ); ?> <i class="fa fa-times fa-2x" aria-hidden="true"></i></div>
                            </li>

                        </ul>
                        */
                        ?>
                    </div>
                    <div class="container" id="section-sub-memu">
                    <?php
                        //  Setup the submenu
                    	//print_r($_SERVER['REQUEST_URI']);
						$_current_section = '';
						$classes = get_body_class();
						if (is_front_page() || is_single() || is_archive() || in_array('wp-custom-logo',$classes) ) {
							$_current_section = 'editoria';
						}
						else {
							$arr = explode('/', $_SERVER['REQUEST_URI']);
							/*end($arr); 
							$_current_section = prev($arr);*/
							$_current_section = current($arr);
							$_current_section = next($arr); 
							$_current_section = next($arr);
							$_current_section = next($arr); 
						}
						//print_r($_current_section);
				        if (has_nav_menu($_current_section.'_sub_menu')) :
					        wp_nav_menu(array(
						        'theme_location'    => $_current_section.'_sub_menu',
						        'menu_class'        => 'nav navbar-nav meni',
						        'container'         => '',
						        'walker'            => new wp_bootstrap_navwalker()
					        ));
				        endif;
                    ?>
                    </div>
				<?php
				// /|\|/|\|/|\|/|\|/|\|/|\|/|\|/|\|/|\|/|\|/|\|/|\|/|\|/|\|/|\|/|\|/|\|/|\|/|\|
				// \|/|\|/|\|/|\|/|\|/|\|/|\|/|\|/|\|/|\|/|\|/|\|/|\|/|\|/|\|/|\|/|\|/|\|/|\|
				if ($activeNewMenu) {
				//if ( $_SERVER['REMOTE_ADDR'] == '188.163.96.81' ) {
					/*
					echo '<div class="drop-menu2">';
					
					wp_nav_menu(array(
						'menu'              => 'Menu Main Opened',
						'menu_class'        => 'tmenu',
						'container'         => ''
					));

					echo '</div>';
*/
				}//else{ ?>
                    <?php if( is_page_template( array('fullwidth-directory-studi-page-template-json.php', 'guida-page-template.php')) || is_singular( array('guida','guida_item')) ) :
						get_template_part( 'template-parts/content', 'guida-toplegal-expanded-menu' );
					else:?>
                    <div class="drop-menu">
                    	<div class="hamburger-col col-sm-4 col-md-4">
					        <?php
					        wp_nav_menu(array(
   						        'theme_location'    => 'hamburger_menu_col_one',
						        'menu_class'        => 'hamburger-nav',
						        'container'         => '',
						        'walker'            => new wp_bootstrap_navwalker()
					        ));
					        ?>
                    	</div>
                    	<div class="hamburger-col col-sm-4 col-md-4">
					        <?php
					        wp_nav_menu(array(
   						        'theme_location'    => 'hamburger_menu_col_two',
						        'menu_class'        => 'hamburger-nav',
						        'container'         => '',
						        'walker'            => new wp_bootstrap_navwalker()
					        ));
					        ?>
                    	</div>
                    	<div class="hamburger-col col-sm-4 col-md-4">
					        <?php
					        wp_nav_menu(array(
   						        'theme_location'    => 'hamburger_menu_col_three',
						        'menu_class'        => 'hamburger-nav', //'nav navbar-nav meni'
						        'container'         => '',
						        'walker'            => new wp_bootstrap_navwalker()
					        ));
					        ?>
                    	</div>
                    </div>
					<?php endif; ?>
				<?php //} ?>
            </nav>
        </div>

        <!--menu-->

    </section>
	<?php 
	
		// Include fullwidth gallery slider
		
		$activeSlider = get_theme_mod( 'tecnavia_homepage_image_slider_enable', '' );
		
		if ($activeSlider && is_front_page()) {
			
			// get category ID
			$catObj = get_category_by_slug( get_theme_mod( 'tecnavia_homepage_image_slider_category', '' ) );
			
			if (isset($catObj->term_id)) {
			
				$id = (int)$catObj->term_id;
				
				// Retrieve images from category
				$args = array(
					'post_status' => 'inherit',
					'post_type' => 'attachment',
					'posts_per_page' => get_theme_mod( 'tecnavia_homepage_image_slider_number', '5' ),
					'cat' => $id
				);
				
				
				$the_query_images = new WP_Query( $args ); 
				
				//var_dump($images);
				
				if ( $the_query_images->have_posts() ) {
				?>	
				<div class="section">
					<div class="container">
						<div class="row">
							
							<div class="col-md-12">
						
								<div id="homepageSliderFullwidth">
									<ul class="slides">
									<?php 
										while ( $the_query_images->have_posts() ) :
											$the_query_images->the_post();
										?>
										<li>
											<div class="imgWrap">
							      				<img class="img" src="<?php echo wp_get_attachment_url( get_the_ID() , false ); ?>" />
							      			</div>
							      			<?php if ( has_excerpt() ) { ?>
							      			<p class="flex-caption"><?php the_excerpt(); ?></p>
							      			<?php } ?>
							    		</li>							
										<?php 
										endwhile;		
										
										wp_reset_postdata();
									?>
									</ul>
								</div>
							
							</div>
							<script type="text/javascript">
								jQuery('#homepageSliderFullwidth').flexslider({
							   	 animation: "slide"
							 	 });
		
							</script>
					</div>
					</div>
				</div>
				<?php 					
				}
			
			}
			
		}
	?>