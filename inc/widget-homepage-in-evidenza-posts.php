<?php

// Register Post List widget.
add_action( 'widgets_init', function () {
	register_widget( 'Post_In_Evidenza_Widget' );
} );

// Widget class.
class Post_In_Evidenza_Widget extends WP_Widget {

	/*-----------------------------------------------------------------------------------*/
	/*	Widget Setup
	/*-----------------------------------------------------------------------------------*/

	public function __construct() {
		parent::__construct(
			'post_in_evidenza_widget',        // Base ID
			__( 'In Evidenza', 'tecnavia' ),        // Name
			array( 'description' => __( 'Display Posts by In Evidenza Category', 'tecnavia' ) )
		);
	}


	/*-----------------------------------------------------------------------------------*/
	/*	Display Widget
    /*-----------------------------------------------------------------------------------*/

	function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$number_of = isset( $instance['number_of'] ) ? (int) $instance['number_of'] : 2;

		echo $args['before_widget'];

		$the_query = new WP_Query( array(
			'post_type'      => 'post',
			'orderby'        => 'date',
			'order'          => 'DESC',
			'posts_per_page' => $number_of,
			'post_status'    => 'publish',
			'category_name'  =>  'In evidenza'
		) );

		?>
			<div class="title">
                <div class="name">
                    <h4><?php echo $title; ?></h4>
                </div>
           </div>
       	<?php
		if ( $the_query->have_posts() ) {
			$i=0;
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				if (($i %2) == 0) {
			?>
			 <div class="col-xs-12 col-sm-6 col-md-6 left-column">
				<div id="post-<?php the_ID(); ?>" <?php post_class( array( $featured_class, 'block-underlined', 'content-row' ) ); ?>>
			        <div class="row post-img-in-evidenza">
				        <div class="col-xs-12 col-sm-12 col-md-6">
				        	<div class="row">
				        		<?php print tecnavia_set_post_background(); ?>
					            <div class="ite visible-xs">
					                <div class="right-news">
					                    <?php print tecnavia_get_post_image( array( 345, 'auto' ), 'img-responsive' ); ?>
					                    
					                </div>
					            </div>
				            </div>
				        </div>   
				        <div class="col-xs-12 col-sm-12 col-md-6 hidden-xs post-content in-evidenza">
				        	<div class="row">
					            <h3 class="entry-title">
					                <a href="<?php print esc_url( get_permalink() ) ?>" title="<?php the_title_attribute(); ?>">
		                               <?php the_title()?>
		                           </a>
					            </h3>
					        </div>
				        </div>
				    </div>
				</div>
			</div>
			<?php
				}	else if (($i % 2) != 0) {
					?>
			 <div class="col-xs-12 col-sm-6 col-md-6 right-column">
				<div id="post-<?php the_ID(); ?>" <?php post_class( array( $featured_class, 'block-underlined', 'content-row' ) ); ?>>
			        <div class="row post-img-in-evidenza">
				        <div class="col-xs-12 col-sm-12 col-md-6">
				        	<div class="row">
				        		<?php print tecnavia_set_post_background(); ?>
					            <div class="ite visible-xs">
					                <div class="right-news">
					                    <?php print tecnavia_get_post_image( array( 345, 'auto' ), 'img-responsive' ); ?>
					                    
					                </div>
					            </div>
				            </div>
				        </div>   
				        <div class="col-xs-12 col-sm-12 col-md-6 hidden-xs post-content in-evidenza">
				        	<div class="row">
					            <h3 class="entry-title">
					                <a href="<?php print esc_url( get_permalink() ) ?>" title="<?php the_title_attribute(); ?>">
		                               <?php the_title()?>
		                           </a>
					            </h3>
					        </div>
				        </div>
				    </div>
				</div>
			</div>
			<?php
				}
				$i++;
			}

			wp_reset_postdata();
		}

		echo $args['after_widget'];
	}


	/*-----------------------------------------------------------------------------------*/
	/*	Update Widget
    /*-----------------------------------------------------------------------------------*/

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		/* Strip tags to remove HTML (important for text inputs). */
		$instance['title']         = strip_tags( $new_instance['title'] );
		$instance['number_of'] = strip_tags( $new_instance['number_of'] );

		return $instance;
	}


	/*-----------------------------------------------------------------------------------*/
	/*	Widget Settings
    /*-----------------------------------------------------------------------------------*/

	function form( $instance ) {
				/* Set up some default widget settings. */
		$defaults = array(
			'title'            => __( 'In Evidenza', 'tecnavia' ),
			'number_of'    => '2'
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		$categories = get_terms( 'category' );
		?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'tecnavia' ) ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
			       value="<?php echo esc_attr( $instance['title'] ); ?>"/>
		</p>
        <p>
            <label
                    for="<?php echo esc_attr( $this->get_field_id( 'number_of' ) ); ?>"><?php _e( 'How many posts do you want to display?', 'tecnavia' ) ?></label>
            <select id="<?php echo esc_attr( $this->get_field_id( 'number_of' ) ); ?>"
                    name="<?php echo esc_attr( $this->get_field_name( 'number_of' ) ); ?>">
				<?php for ( $i = 1; $i < 20; $i ++ ) { ?>
                    <option <?php echo( $i == $instance['number_of'] ? 'selected="selected"' : '' ); ?>
                            value="<?php echo esc_attr( $i ); ?>"><?php echo $i; ?></option>
				<?php } ?>
            </select>
        </p>

		<?php
	}

}