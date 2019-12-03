<?php

// Register Post List widget.
add_action( 'widgets_init', function () {
	register_widget( 'Widget_White_Paper_Latest_Posts' );

} );

// Widget class.
class Widget_White_Paper_Latest_Posts extends WP_Widget {

	/*-----------------------------------------------------------------------------------*/
	/*	Widget Setup
	/*-----------------------------------------------------------------------------------*/

	public function __construct() {
		parent::__construct(
			'widget_white_paper_latest_posts',        // Base ID
			__( 'White Paper Latest Posts', 'tecnavia' ),        // Name
			array( 'description' => __( 'show latest White Paper posts', 'tecnavia' ) )
		);
	}


	/*-----------------------------------------------------------------------------------*/
	/*	Display Widget
    /*-----------------------------------------------------------------------------------*/

	function widget( $args, $instance ) {

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$post_per_page = isset( $instance['$post_per_page'] ) ? (int) $instance['$post_per_page'] : 5;
		
		echo $args['before_widget'];
		$the_query = new WP_Query( array(
			'post_type'      => 'white_paper',
			'posts_per_page' => $post_per_page,
			'post_status'    => 'publish',
			'order'  => 'DESC'
		) );
		?>
		<div class="whitepaper logo">
            <?php if ( is_active_sidebar( 'white-paper-widget-logo' ) ) : ?>
                <?php dynamic_sidebar( 'white-paper-widget-logo' ); ?>
            <?php endif; ?>
		</div>
		<div class="row">
		<?php
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$content = get_the_content();
				$excerpt = substr( $content, 0, 200);
				?>
					<div class="col-md-6 col-lg-6" style="height: 180px;">
						<p><?php echo $excerpt.'...'; ?></p>
						<div class="date" style="text-align: left;  font-size: 14px!important;"><?php echo get_the_date(); ?></div>
						<?php print tecnavia_get_post_image(array(360, 'auto'), 'img-responsive');?>
					</div>
				<?php
			}
			?>
		</div><!--end row-->
			<?php
			wp_reset_postdata();
		echo $args['after_widget'];
	}


	/*-----------------------------------------------------------------------------------*/
	/*	Update Widget
    /*-----------------------------------------------------------------------------------*/

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['$post_per_page']   = strip_tags( $new_instance['$post_per_page'] );
		$instance['title']         = strip_tags( $new_instance['title'] );
		return $instance;
	}

	/*-----------------------------------------------------------------------------------*/
	/*	Widget Settings
    /*-----------------------------------------------------------------------------------*/

	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
			'title'            => __( '', 'tecnavia' ),
			'$post_per_page'	=> 5,
			);

		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'tecnavia' ) ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
			       value="<?php echo esc_attr( $instance['title'] ); ?>"/>
		</p>
		<p>
            <label for="<?php echo esc_attr( $this->get_field_id( '$post_per_page' ) ); ?>"><?php _e( 'Number of posts', 'tecnavia' ) ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( '$post_per_page' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( '$post_per_page' ) ); ?>"
                   value="<?php echo esc_attr( $instance['$post_per_page'] ); ?>"/>
        </p>
        <?php
	}

}