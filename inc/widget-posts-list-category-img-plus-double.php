<?php

// Register Post List widget.
add_action( 'widgets_init', function () {
	register_widget( 'Widget_Posts_List_Category_Img_Plus_Double_Child' );

} );

// Widget class.
class Widget_Posts_List_Category_Img_Plus_Double_Child extends WP_Widget {

	/*-----------------------------------------------------------------------------------*/
	/*	Widget Setup
	/*-----------------------------------------------------------------------------------*/

	public function __construct() {
		parent::__construct(
			'widget_posts_list_category_img_plus_double',        // Base ID
			__( 'Posts in column img+ double', 'tecnavia' ),        // Name
			array( 'description' => __( 'show posts in double column by  (N posts with image + M posts without image)', 'tecnavia' ) )
			//'post_by_category_widget',        // Base ID
			//__( 'Posts by Category', 'tecnavia' ),        // Name
			//array( 'description' => __( 'Display Posts by Category', 'tecnavia' ) )
		);
	}


	/*-----------------------------------------------------------------------------------*/
	/*	Display Widget
    /*-----------------------------------------------------------------------------------*/

	function widget( $args, $instance ) {

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$title2 = apply_filters( 'widget_title', empty( $instance['title2'] ) ? '' : $instance['title2'], $instance, $this->id_base );
	//	$icon = isset( $instance['icon'] ) ? $instance['icon'] : '';
		$cat = empty( $instance['category_name'] ) ? '' : $instance['category_name'];
		$cat2 = empty( $instance['category_name2'] ) ? '' : $instance['category_name2'];
		$img_on = isset( $instance['img_on'] ) ? (int) $instance['img_on'] : 1;
		$img_off = isset( $instance['img_off'] ) ? (int) $instance['img_off'] : 3;
		$post_per_page = $img_on + $img_off;
		//$post_per_page = isset( $instance['post_per_page'] ) ? $instance['post_per_page'] : 2;
		
		echo $args['before_widget'];
		?>
		<div class="row">
			<div class="col-sm-6 col-md-5">
		<?php	
		if ( false === ( $the_query = get_transient( 'widget_posts_list_category_img_plus_double_' . $cat ) ) ) {
		
			$the_query = new WP_Query( array(
				'post_type'      => 'post',
				'orderby'        => 'date',
				'order'          => 'DESC',
				'posts_per_page' => $post_per_page,
				'post_status'    => 'publish',
				'category_name'  => $cat,
				'ignore_sticky_posts' => true,
				'date_query' => array(
						array(
								'after'     => '1 month ago'
						)
				)
			) );
			
			if ( !$the_query->have_posts() ) {
				
				$the_query = new WP_Query( array(
						'post_type'      => 'post',
						'orderby'        => 'date',
						'order'          => 'DESC',
						'posts_per_page' => $post_per_page,
						'post_status'    => 'publish',
						'category_name'  => $cat,
						'ignore_sticky_posts' => true,
						
				) );
				
			}
			
			set_transient( 'widget_posts_list_category_img_plus_double_' . $cat, $the_query, 30 );
			
		}

		if ( $the_query->have_posts() ) :?>

			<div class="title">
                <div class="name">
                    <h4><?php echo $title; ?></h4>
                </div>
           	<?php
			$idObj = get_category_by_slug( $cat );
			//echo '<a href="'.esc_url(get_category_link( $idObj->term_id )).'" title="'.  __( 'MORE', 'tecnavia' ) .'">'.  __( 'MORE', 'tecnavia' ) .' &gt;</a>';
			?>
			</div>
           	<div class="content">
           	<?php
			$num = 0;
			while ( $the_query->have_posts() ) {
				$num++;
				$the_query->the_post();
				
				if ($num <= $img_on){
					get_template_part( 'template-parts/content', 'row-img-plus' );
				}else{
					get_template_part( 'template-parts/content', 'row-img-minus' );
				}
				
			}
			?>
			</div><!--content-->
			<?php
			wp_reset_postdata();
		endif;
		?>
		</div><!--col-md-5-->
		<div class="col-sm-6 col-md-5">
		<?php
		if ( false === ( $the_query = get_transient( 'widget_posts_list_category_img_plus_double_' . $cat2 ) ) ) {
			
		
			$the_query = new WP_Query( array(
				'post_type'      => 'post',
				'orderby'        => 'date',
				'order'          => 'DESC',
				'posts_per_page' => $post_per_page,
				'post_status'    => 'publish',
				'category_name'            => $cat2,
				'ignore_sticky_posts' => true,
				'date_query' => array(
						array(
								'after'     => '1 month ago'
						)
				)
			) );
			
			if ( !$the_query->have_posts() ) {
				
				$the_query = new WP_Query( array(
						'post_type'      => 'post',
						'orderby'        => 'date',
						'order'          => 'DESC',
						'posts_per_page' => $post_per_page,
						'post_status'    => 'publish',
						'category_name'            => $cat2,
						'ignore_sticky_posts' => true
					
				) );
				
			}
			
			set_transient( 'widget_posts_list_category_img_plus_double_' . $cat2, $the_query, 30 );
		
		}

		if ( $the_query->have_posts() ) : ?>

			<div class="title">
                    <div class="name">
                        <h4><?php echo $title2; ?></h4>
                    </div>
            <?php
			$idObj = get_category_by_slug( $cat2 );
			//echo '<a href="'.esc_url(get_category_link( $idObj->term_id )).'" title="'.  __( 'MORE', 'tecnavia' ) .'">'.  __( 'MORE', 'tecnavia' ) .' &gt;</a>';
			?>
			</div>
               <div class="content">
           	<?php
			$num = 0;
			while ( $the_query->have_posts() ) {
				$num++;
				$the_query->the_post();

				if ($num <= $img_on){
					get_template_part( 'template-parts/content', 'row-img-plus' );
				}else{
					get_template_part( 'template-parts/content', 'row-img-minus' );
				}

			}
			?>
			</div>
			<?php // content
			wp_reset_postdata();
		endif;
		?>
		</div><!--col-md-5-->
		<div class="col-xs-12 col-sm-12 col-md-2 no-padding-right  homeMainPostRight">
			<?php if ( is_active_sidebar( 'homepge_posts_category_img_plus_double_sidebar' ) ) : ?>
	            <?php dynamic_sidebar( 'homepge_posts_category_img_plus_double_sidebar' ); ?>
	        <?php endif; ?>
		</div>
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
		$instance['category_name']   = strip_tags( $new_instance['category_name'] );
		$instance['category_name2']   = strip_tags( $new_instance['category_name2'] );
		$instance['img_on']   = strip_tags( $new_instance['img_on'] );
		$instance['img_off']   = strip_tags( $new_instance['img_off'] );

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
			'category_name'      => '',
			'category_name2'      => '',
			'img_on'	=> 1,
			'img_off'	=> 3
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

		<?php /*
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>"><?php _e( 'Icon:', 'tecnavia' ) ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'icon' ) ); ?>"
                   value="<?php echo esc_attr( $instance['icon'] ); ?>"/>
        </p>
		*/ ?>

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
			<label for="<?php echo esc_attr( $this->get_field_id( 'title2' ) ); ?>"><?php _e( 'Title second:', 'tecnavia' ) ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title2' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'title2' ) ); ?>"
				   value="<?php echo esc_attr( $instance['title2'] ); ?>"/>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'category_name2' ) ); ?>"><?php _e( 'Category second', 'tecnavia' ) ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'category_name2' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'category_name2' ) ); ?>">
				<?php foreach ($categories as $category) { ?>
					<option <?php echo( $category->slug == $instance['category_name2'] ? 'selected="selected"' : '' ); ?>
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

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'img_off' ) ); ?>"><?php _e( 'Number of posts without image:', 'tecnavia' ) ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'img_off' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'img_off' ) ); ?>"
				   value="<?php echo esc_attr( $instance['img_off'] ); ?>"/>
		</p>
		<?php
	}

}