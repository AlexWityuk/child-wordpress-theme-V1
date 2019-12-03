<?php

// Register Post List widget.
add_action( 'widgets_init', function () {
	register_widget( 'Homepage_Fullwidth_Post_Carousel_Child' );
} );

	// Widget class.
	class Homepage_Fullwidth_Post_Carousel_Child extends WP_Widget {

		/*-----------------------------------------------------------------------------------*/
		/*	Widget Setup
		 /*-----------------------------------------------------------------------------------*/

		public function __construct() {
			parent::__construct(
					'homepage_fullwidth_post_carousel',        // Base ID
					__( 'Homepage Fullwidth Post Carousel', 'tecnavia' ),        // Name
					array( 'description' => __( 'Display Post inside carousel plus 4 homepage posts', 'tecnavia' ) )
					);
		}


		/*-----------------------------------------------------------------------------------*/
		/*	Display Widget
		 /*-----------------------------------------------------------------------------------*/

		function widget( $args, $instance ) {


			$offset = isset( $instance['post_offset'] ) ? (int) $instance['post_offset'] : 0;
			$slide_count = isset( $instance['slide_count'] ) ? (int) $instance['slide_count'] : 4;

			echo $args['before_widget'];

			?>
		<div class="col-md-12">
		<?php 
	
		$carousel = new WP_Query( array(
			'post_type'      => 'post',
			'posts_per_page' => $slide_count,
			'post_status'    => 'publish',
			'offset'         => 0,
			'ignore_sticky_posts' => 1,
			'meta_query'     => array(
				array(
					'key'   => 'is_in_homepage_flow',
					'value' => 'yes',
				)
			),
			'orderby'        => 'menu_order ID',
			'order'          => 'DESC',
			'category_name'  => 'primo-piano'
		) );
		
		
		
		
		// Check if the post(s) exist.
		if ( $carousel->have_posts() ) {				
		?>
			<div class="col-md-8 no-padding-left no-padding-right homeSliderCarouselWrap">
				<div class="homeSliderCarousel">
				<ul class="slides">
				<?php 
				
				while ( $carousel->have_posts() ) {
				
					$carousel->the_post();
					
					$catenaccio = get_post_meta( get_the_ID(), 'post_catenaccio', true );
					$occhiello  = get_post_meta( get_the_ID(), 'post_occhiello', true );
					
					$excerpt = get_the_excerpt();
					
					if ( ! empty( $catenaccio ) ) {
						$excerpt = $catenaccio;
					}
					
					if ( empty( $excerpt ) ) {
						$excerpt = get_the_content();
					}
					
					if ( has_post_thumbnail() ) {
							
						$image = get_the_post_thumbnail_url( get_the_ID(),  'medium_large');
							
					} else if ( $default_image ) {
							
						$image = get_theme_mod( 'tecnavia_default_image_post' );
					
					}
				
				?>
					<li class="slide">
						<div class="main-image-block">
							<div class="main-image-bg" style="background-image:url('<?php echo $image; ?>');"></div>
		                    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		                        <div class="carousel-caption">
		                        	<h4 class="entry-title">
									<?php if ( empty( $occhiello ) ) { ?>
										<?php the_title( sprintf( '<a href="%s" title="%s">', esc_url( get_permalink() ), the_title_attribute( array( 'echo' => false ) ) ), '</a>' ); ?>
									<?php } else { ?>
		                               <a href="<?php echo esc_url( get_permalink() ); ?>"
		                                                           title="<?php printf( "%s - %s", $occhiello, get_the_title() ); ?>"><span
		                                                class="occhiello-home"><?php echo $occhiello; ?></span>
		                                        - <?php the_title(); ?></a>
									<?php } ?>
		                           <div class="red mrkt">
                                <i class="fa fa-bookmark"
                                   aria-hidden="true"></i> <?php print tecnavia_get_post_category( get_the_ID() ); ?>
                                <div class="arr-down"></div>
                            </div>
		                          	</h4>
		                            <p class="text-left date">
										<i class="fa fa-calendar" aria-hidden="true"></i><span class="posted-on"><time class="entry-date published updated" datetime=""><?php  the_time('F j, Y'); ?></time></span>
									</p>
		                            
		                        </div>
		                    </div>
		                   
		                </div>					
					</li>
				<?php 
				}
				
				wp_reset_postdata();
				
				?>
				</ul>
				</div>
			</div>
			<script type="text/javascript">
				jQuery('.homeSliderCarousel').flexslider({
			    animation: "slide"
			  });
			</script>
		<?php 
		} 
		
		$_args = array(
				'post_type'      => 'post',
				'posts_per_page' => 2,
				'orderby' => 'menu_order ID',
				'order'   => 'DESC',
				'offset' => $offset,
				'ignore_sticky_posts' => 1,
				'meta_query' => array(
						array(
								'key'     => 'is_in_homepage_flow',
								'value'   => 'yes',
						),
				),
				 
		
		);
		
		// The post query.
		$mainPosts = new WP_Query( $_args );

		$countSeparator = 0;
		
		// Check if the post(s) exist.
		if ( $mainPosts->have_posts() ) {
		?>
			<div class="col-md-4 no-padding-right  homeMainPostRight">
			<?php if ( is_active_sidebar( 'homepage_fullwidth_post_carousel' ) ) : ?>
		                <?php dynamic_sidebar( 'homepage_fullwidth_post_carousel' ); ?>
		            <?php endif; ?>
			</div>
		<?php 
		
		}
		
		?>
		</div>
		<?php 
		
		echo $args['after_widget'];
	}


	/*-----------------------------------------------------------------------------------*/
	/*	Update Widget
    /*-----------------------------------------------------------------------------------*/

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		/* Strip tags to remove HTML (important for text inputs). */
		$instance['post_offset'] = strip_tags( $new_instance['post_offset'] );
		$instance['slide_count'] = strip_tags( $new_instance['slide_count'] );

		return $instance;
	}


	/*-----------------------------------------------------------------------------------*/
	/*	Widget Settings
    /*-----------------------------------------------------------------------------------*/

	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(		
			'post_offset'          => '0',
			'slide_count'		=> 4
		);

		$instance = wp_parse_args( (array) $instance, $defaults );
		?>

		<p>
		    <input class="widefat" type="number"  id="<?php echo $this->get_field_id( 'post_offset' ); ?>" name="<?php echo $this->get_field_name( 'post_offset' ); ?>" value="<?php echo esc_attr( $instance['post_offset'] ); ?>"/> <br>
		    <label for="<?php echo $this->get_field_id( 'post_offset' ); ?>"><?php _e( 'Offset of retrieved homepage posts', 'tecnavia' ) ?></label>
		</p>
		<p>
		    <input class="widefat" type="number"  id="<?php echo $this->get_field_id( 'slide_count' ); ?>" name="<?php echo $this->get_field_name( 'slide_count' ); ?>" value="<?php echo esc_attr( $instance['slide_count'] ); ?>"/> <br>
		    <label for="<?php echo $this->get_field_id( 'slide_count' ); ?>"><?php _e( 'Number of slides', 'tecnavia' ) ?></label>
		</p>
 
		<?php
	}

}