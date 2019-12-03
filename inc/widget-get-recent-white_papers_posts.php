<?php

// Register Post List widget.
add_action( 'widgets_init', function () {
	register_widget( 'Widget_Get_Recent_White_Papers_Posts' );

} );

// Widget class.
class Widget_Get_Recent_White_Papers_Posts extends WP_Widget {

	/*-----------------------------------------------------------------------------------*/
	/*	Widget Setup
	/*-----------------------------------------------------------------------------------*/

	public function __construct() {
		parent::__construct(
			'widget_get_recent_white_papers_posts',        // Base ID
			__( 'Recent White Papers Posts', 'tecnavia' ),        // Name
			array( 'description' => __( 'shows the gallery of the most recent White paper posts created', 'tecnavia' ) )
		);
	}


	/*-----------------------------------------------------------------------------------*/
	/*	Display Widget
    /*-----------------------------------------------------------------------------------*/

	function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		
		$args = array(
			'taxonomy' => 'white-paper-category',
			'hide_empty' => false,
		);
		$terms = get_terms( $args );		

		echo $args['before_widget'];

		if (! empty($title)) :
		?>
			<div class="textwidget custom-html-widget">
				<div style="clear:both"></div>
				<div style="margin-top:15px" class="mrkt2 att hidden-xs">
					<div class="wrap">
						<i class="fa fa-bookmark" aria-hidden="true"></i>
						<span><?php echo $title; ?></span>
						<div class="arr-down"></div>
					</div>
				</div>
			</div>
		<?php endif; ?>
			<div class="white-paper">
				<?php
					foreach ($terms as $term) {
						$term_link = get_term_link( $term -> term_id);
						?>
						<div class="grid-item col-sm-3 col-md-3 no-padding-right">
							<div class="grid-content" style="overflow: hidden;">
								<a class="grid-href" href="<?php echo $term_link; ?>">
									<?php echo $term->name ; ?>
								</a>
							</div>
						</div>
						<?php
					}
					wp_reset_postdata();
				?>
			</div><!--white-paper-->
		<?php
		echo $args['after_widget'];
	}

	/*-----------------------------------------------------------------------------------*/
	/*	Update Widget
    /*-----------------------------------------------------------------------------------*/

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		/* Strip tags to remove HTML (important for text inputs). */
		$instance['title']         = strip_tags( $new_instance['title'] );

		return $instance;
	}


	/*-----------------------------------------------------------------------------------*/
	/*	Widget Settings
    /*-----------------------------------------------------------------------------------*/

	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
			'title'      => ''
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'tecnavia' ) ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
			       value="<?php echo esc_attr( $instance['title'] ); ?>"/>
        </p>
		<?php
	}

}