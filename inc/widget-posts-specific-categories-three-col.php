<?php

// Register Post List widget.
add_action( 'widgets_init', function () {
	register_widget( 'Widget_Posts_Specific_Categories_Three_Column' );

} );

// Widget class.
class Widget_Posts_Specific_Categories_Three_Column extends WP_Widget {

	/*-----------------------------------------------------------------------------------*/
	/*	Widget Setup
	/*-----------------------------------------------------------------------------------*/

	public function __construct() {
		parent::__construct(
			'widget-posts-specific-categories-three-col',        // Base ID
			__( 'Posts from two specific categories', 'tecnavia' ),        // Name
			array( 'description' => __( 'Retrieve posts from 2 specific categories with img', 'tecnavia' ) )
		);
	}


	/*-----------------------------------------------------------------------------------*/
	/*	Display Widget
    /*-----------------------------------------------------------------------------------*/

	function widget( $args, $instance ) {

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$title2 = apply_filters( 'widget_title', empty( $instance['title2'] ) ? '' : $instance['title2'], $instance, $this->id_base );
		$cat = empty( $instance['category_name_specif'] ) ? '' : $instance['category_name_specif'];
		$cat2 = empty( $instance['category_name_specif2'] ) ? '' : $instance['category_name_specif2'];
		$post_per_page_1 = isset( $instance['post_per_page_1'] ) ? (int) $instance['post_per_page_1'] : 2;
		$post_per_page_2 = isset( $instance['post_per_page_2'] ) ? (int) $instance['post_per_page_2'] : 4;

		echo $args['before_widget'];
		?>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-4 left-sm">
		<?php	
		
		$the_query = new WP_Query( array(
				'post_type'      => 'post',
				'orderby'        => 'date',
				'order'          => 'DESC',
				'posts_per_page' => $post_per_page_1,
				'post_status'    => 'publish',
				'category_name'  => $cat,
				'ignore_sticky_posts' => true,
				
		) );

		if ( $the_query->have_posts() ) :?>

			<div class="title">
                <div class="name">
                    <h4><?php echo $title; ?></h4>
                </div>
           	<?php
			$idObj = get_category_by_slug( $cat );
			?>
			</div>
           	<div class="content">
           	<?php
			$num = 0;
			while ( $the_query->have_posts() ) {
				$num++;
				$the_query->the_post();
				
				get_template_part( 'template-parts/content', 'row-img-plus' );
				
			}
			?>
			</div><!--content-->
			<?php
			wp_reset_postdata();
		endif;
		?>
		</div><!--col-md-4-->
		<div class="col-xs-12 col-sm-12 col-md-8 right-sm">
		<?php
				
		$the_query = new WP_Query( array(
				'post_type'      => 'post',
				'orderby'        => 'date',
				'order'          => 'DESC',
				'posts_per_page' => $post_per_page_2,
				'post_status'    => 'publish',
				'category_name'            => $cat2,
				'ignore_sticky_posts' => true
			
		) );

		if ( $the_query->have_posts() ) : ?>
			<div class="title">
                    <div class="name">
                        <h4><?php echo $title2; ?></h4>
                    </div>
            <?php
			$idObj = get_category_by_slug( $cat2 );
			?>
			</div>
           	<div class="content">
           		<div class="row">
           	<?php
			$num = 0;
			while ( $the_query->have_posts() ) :
				$num++;
				$the_query->the_post();
				?>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<?php
						get_template_part( 'template-parts/content', 'row-img-plus' );
					?>
				</div>
			<?php
			 endwhile;
			?>
				</div>
			</div>
			<?php // content
			wp_reset_postdata();
		endif;
		?>
		</div><!--col-md-8-->
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
		$instance['title2']         = strip_tags( $new_instance['title2'] );
		$instance['category_name_specif']   = strip_tags( $new_instance['category_name_specif'] );
		$instance['category_name_specif2']   = strip_tags( $new_instance['category_name_specif2'] );
		$instance['post_per_page_1']   = strip_tags( $new_instance['post_per_page_1'] );
		$instance['post_per_page_2']   = strip_tags( $new_instance['post_per_page_2'] );

		return $instance;
	}


	/*-----------------------------------------------------------------------------------*/
	/*	Widget Settings
    /*-----------------------------------------------------------------------------------*/

	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
			'title'            => __( 'Posts by Category', 'tecnavia' ),
			'title2'            => __( 'Posts by Category', 'tecnavia' ),
			'category_name_specif'      => '',
			'category_name_specif2'      => '',
			'post_per_page_1'	=> 2,
			'post_per_page_2'	=> 4
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
			<label for="<?php echo esc_attr( $this->get_field_id( 'category_name_specif' ) ); ?>"><?php _e( 'Category', 'tecnavia' ) ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'category_name_specif' ) ); ?>"
			        name="<?php echo esc_attr( $this->get_field_name( 'category_name_specif' ) ); ?>">
				<?php foreach ($categories as $category) { ?>
					<option <?php echo( $category->slug == $instance['category_name_specif'] ? 'selected="selected"' : '' ); ?>
						value="<?php echo esc_attr( $category->slug ); ?>"><?php echo $category->name; ?></option>
				<?php } ?>
			</select>
		</p>
		<p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'post_per_page_1' ) ); ?>"><?php _e( 'Number of posts with image:', 'tecnavia' ) ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'post_per_page_1' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'post_per_page_1' ) ); ?>"
                   value="<?php echo esc_attr( $instance['post_per_page_1'] ); ?>"/>
        </p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title2' ) ); ?>"><?php _e( 'Title second:', 'tecnavia' ) ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title2' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'title2' ) ); ?>"
				   value="<?php echo esc_attr( $instance['title2'] ); ?>"/>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'category_name_specif2' ) ); ?>"><?php _e( 'Category second', 'tecnavia' ) ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'category_name_specif2' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'category_name_specif2' ) ); ?>">
				<?php foreach ($categories as $category) { ?>
					<option <?php echo( $category->slug == $instance['category_name_specif2'] ? 'selected="selected"' : '' ); ?>
						value="<?php echo esc_attr( $category->slug ); ?>"><?php echo $category->name; ?></option>
				<?php } ?>
			</select>
		</p>
		<p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'post_per_page_2' ) ); ?>"><?php _e( 'Number of posts with image:', 'tecnavia' ) ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'post_per_page_2' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'post_per_page_2' ) ); ?>"
                   value="<?php echo esc_attr( $instance['post_per_page_2'] ); ?>"/>
        </p>
		<?php
	}

}