<?php

// Register Post List widget.
add_action( 'widgets_init', function () {
	register_widget( 'Widget_That_Retrieve_The_Most_Read_Posts' );

} );

//Widget class
class Widget_That_Retrieve_The_Most_Read_Posts extends WP_Widget {

	/*-----------------------------------------------------------------------------------*/
	/*	Widget Setup
	/*-----------------------------------------------------------------------------------*/

	public function __construct() {
		parent::__construct(
			'widget_that_retrieve_the_most_read_posts',        // Base ID
			__( 'Most read posts', 'tecnavia' ),        // Name
			array( 'description' => __( 'show most read posts', 'tecnavia' ) )
		);
	}

	/*-----------------------------------------------------------------------------------*/
	/*	Display Widget
    /*-----------------------------------------------------------------------------------*/

	function widget( $args, $instance ) {
		global $num_post;
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$post_per_page = isset( $instance['$post_per_page'] ) ? (int) $instance['$post_per_page'] : 5;

		echo $args['before_widget'];
		$the_query = new WP_Query( array(
			'post_type'      => 'post',
			'posts_per_page' => $post_per_page,
			'post_status'    => 'publish',
			'meta_key' => 'post_view_count',
            'orderby' => 'meta_value_num',
            'order' => 'DESC'
		) );

		if ( $the_query->have_posts() ):
			$num_post = 0;
		?>
		<div class="title">
            <div class="name">
                <h4><?php echo $title; ?></h4>
            </div>
		</div>
		<?php
			while ( $the_query->have_posts() ) :
				$the_query->the_post();
				$num_post++;
				?>
				<div class="most-read-post">
				<?php
				get_template_part( 'template-parts/content', 'row-most-read-posts' );
				?>
				</div>
				<?php
			endwhile;
		endif;
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
			'title'            => __( 'Posts by Category', 'tecnavia' ),
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