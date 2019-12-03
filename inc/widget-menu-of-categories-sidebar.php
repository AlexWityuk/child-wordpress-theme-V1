<?php

// Register Post List widget.
add_action( 'widgets_init', function () {
	register_widget( 'Widget_Menu_of_Categories_Sidebar' );

} );

// Widget class.
class Widget_Menu_of_Categories_Sidebar extends WP_Widget {

	/*-----------------------------------------------------------------------------------*/
	/*	Widget Setup
	/*-----------------------------------------------------------------------------------*/

	public function __construct() {
		parent::__construct(
			'widget-menu-of-categories-sidebar',        // Base ID
			__( 'Menu of Categories', 'tecnavia' ),        // Name
			array( 'description' => __( 'showes Diritto A-Z Sidebar Menu with exist categories', 'tecnavia' ) )
		);
	}


	/*-----------------------------------------------------------------------------------*/
	/*	Display Widget
    /*-----------------------------------------------------------------------------------*/

	function widget( $args, $instance ) {

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		echo $args['before_widget'];
		?>
			<div class="title">
                <div class="name">
                    <h4><?php echo $title; ?></h4>
                </div>
			</div>
			<?php
		        if (has_nav_menu('diritto-a-z-sidebar-menu')) :
			        wp_nav_menu(array(
				        'theme_location'    => 'diritto-a-z-sidebar-menu',
				        'menu_class'        => 'nav navbar-nav meni',
				        'container'         => '',
				        'walker'            => new wp_bootstrap_navwalker()
			        ));
		        endif;
	        ?>
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
			'title'   => __( 'Menu of Categories', 'tecnavia' )
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
		<?php
	}

}