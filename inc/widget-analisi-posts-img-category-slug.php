<?php

// Register Post List widget.
add_action( 'widgets_init', function () {
	register_widget( 'Widget_Analisi_Posts_Img_Category_Slug' );

} );

// Widget class.
class Widget_Analisi_Posts_Img_Category_Slug extends WP_Widget {

	/*-----------------------------------------------------------------------------------*/
	/*	Widget Setup
	/*-----------------------------------------------------------------------------------*/

	public function __construct() {
		parent::__construct(
			'widget-analisi-posts-img-category-slug',        // Base ID
			__( 'Analisi Post Images List By Category Slug', 'tecnavia' ),        // Name
			array( 'description' => __( 'show posts by category slug', 'tecnavia' ) )
		);
	}


	/*-----------------------------------------------------------------------------------*/
	/*	Display Widget
    /*-----------------------------------------------------------------------------------*/

	function widget( $args, $instance ) {

		$slug = empty( $instance['category_name'] ) ? '' : $instance['category_name'];
		
		$cat = get_category_by_slug( $slug );

		echo $args['before_widget'];
		$the_query = new WP_Query( array(
			'post_type'      => 'post',
			'posts_per_page' => 1,
			'post_status'    => 'publish',
			'category_name'  => $slug
		) );
		$cat_link = get_category_link( $cat->cat_ID );
		?>
		<div class="ctname">
	        <div class="name">
	            <h4><?php echo $cat->cat_name; ?></h4>
	        </div>
	        <div class="arch-btn"><a href="<?php echo $cat_link; ?>">Archivo</a></div>
		</div>
		<div class="row">
			<div class="col-sm-12 col-md-6 left-column">
				<?php
					while ( $the_query->have_posts() ) {
						$the_query->the_post();
					 	$GLOBALS['background'] = tecnavia_set_post_background(330);
						get_template_part( 'template-parts/content', 'get-post-properties' );
					}
					wp_reset_postdata();
				?>
			</div><!--col-md-6-->
			<div class="col-sm-12 col-md-6 right-column">
				<?php 
				$the_query = new WP_Query( array(
					'post_type'      => 'post',
					'posts_per_page' => 4,
					'offset'         => 1,
					'post_status'    => 'publish',
					'category_name'  => $slug
				) );
				while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
				<div class="col-sm-6 col-md-6">
		            <?php 
		            $GLOBALS['background'] = tecnavia_set_post_background(150);
		            get_template_part( 'template-parts/content', 'get-post-properties' ); 
		            ?>
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
			'category_name'      => ''
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		$categories = get_terms( 'category' );
		?>

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