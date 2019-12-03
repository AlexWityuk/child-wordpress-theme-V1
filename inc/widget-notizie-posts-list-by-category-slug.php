<?php

// Register Post List widget.
add_action( 'widgets_init', function () {
	register_widget( 'Widget_Notizie_Posts_List_By_Category_Slug' );

} );

// Widget class.
class Widget_Notizie_Posts_List_By_Category_Slug extends WP_Widget {

	/*-----------------------------------------------------------------------------------*/
	/*	Widget Setup
	/*-----------------------------------------------------------------------------------*/

	public function __construct() {
		parent::__construct(
			'widget-notizie-posts-list-by-category-slug',        // Base ID
			__( 'Notizie Posts List By Category Slug', 'tecnavia' ),        // Name
			array( 'description' => __( 'show posts by category slug', 'tecnavia' ) )
		);
	}


	/*-----------------------------------------------------------------------------------*/
	/*	Display Widget
    /*-----------------------------------------------------------------------------------*/

	function widget( $args, $instance ) {

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$cat = empty( $instance['category_name'] ) ? '' : $instance['category_name'];
		
		echo $args['before_widget'];
		$the_query = new WP_Query( array(
			'post_type'      => 'post',
			'posts_per_page' => 2,
			'post_status'    => 'publish',
			'category_name'            => $cat
		) );
		?>
		<div class="row">
			<div class="title">
                <div class="name">
                    <h4><?php echo $title; ?></h4>
                </div>
			</div>
			<?php if (!is_archive()): ?>
			<div class="col-sm-12 col-md-6 left-column">
				<?php
					while ( $the_query->have_posts() ) {
						$the_query->the_post();
						get_template_part( 'template-parts/content', 'row-img-plus' );
					}
					wp_reset_postdata();
				?>
			</div><!--col-md-6-->
			<?php endif; ?>
			<?php if (!is_archive()): ?>
			<div class="col-sm-12 col-md-6 right-column">
			<?php else: ?>
			<div class="right-column">
			<?php endif; ?>
				<?php 
				$the_query = new WP_Query( array(
					'post_type'      => 'post',
					'posts_per_page' => 3,
					'offset'         => 2,
					'post_status'    => 'publish',
					'category_name'            => $cat
				) );
				while ( $the_query->have_posts() ) : $the_query->the_post();?>
				<div class="col-xs-12 col-sm-4 col-md-4">
					<?php get_template_part( 'template-parts/content', 'row-img-vertical' ); ?>
				</div>
				<?php 
					endwhile; 
					wp_reset_postdata();
				?>
			</div><!--col-md-6-->
		</div><!--row--> 
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
		$instance['category_name']   = strip_tags( $new_instance['category_name'] );

		return $instance;
	}


	/*-----------------------------------------------------------------------------------*/
	/*	Widget Settings
    /*-----------------------------------------------------------------------------------*/

	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
			'title'            => __( 'Posts by Category', 'tecnavia' ),
			'category_name'      => ''
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
			<label for="<?php echo esc_attr( $this->get_field_id( 'category_name' ) ); ?>"><?php _e( 'Category', 'tecnavia' ) ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'category_name' ) ); ?>"
			        name="<?php echo esc_attr( $this->get_field_name( 'category_name' ) ); ?>">
				<?php foreach ($categories as $category) { ?>
					<option <?php echo( $category->slug == $instance['category_name'] ? 'selected="selected"' : '' ); ?>
						value="<?php echo esc_attr( $category->slug ); ?>"><?php echo $category->name; ?></option>
				<?php } ?>
			</select>
		</p>

		<p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'img_on' ) ); ?>"><?php _e( 'Number of posts with image:', 'tecnavia' ) ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'img_on' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'img_on' ) ); ?>"
                   value="<?php echo esc_attr( $instance['img_on'] ); ?>"/>
        </p>
		<?php
	}

}