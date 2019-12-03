<?php

// Register Post List widget.
add_action( 'widgets_init', function () {
	register_widget( 'Osservatori_Post_List_Widget' );
} );

// Widget class.
class Osservatori_Post_List_Widget extends WP_Widget {

	/*-----------------------------------------------------------------------------------*/
	/*	Widget Setup
	/*-----------------------------------------------------------------------------------*/

	public function __construct() {
		parent::__construct(
			'osservatori_post_list_widget',        // Base ID
			'Osservatori post - list',        // Name
			array( 'description' => __( 'Display Popular Posts in a list', 'tecnavia' ) )
		);
	}


	/*-----------------------------------------------------------------------------------*/
	/*	Display Widget
    /*-----------------------------------------------------------------------------------*/

	function widget( $args, $instance ) {

		$post_per_page = isset( $instance['per_page'] ) ? (int) $instance['per_page'] : 3;

		echo $args['before_widget'];

		
		?>
		<div class="youtube-list-wrap">
			<div class="row">
				<?php if ($post_per_page < 4) : ?>
				<div class="col-xs-12 col-sm-6 col-md-6">
				<?php else: ?>
				<div class="col-xs-12 col-sm-12 col-md-12">
				<?php endif; ?>
					<div class="row">
		<?php 
				$args = array(
					'posts_per_page' => $post_per_page,
					'post_type' => 'osservatori'					
				);
				
				$_post = get_posts( $args );
				
				//var_dump($_post[0]->post_title);
				
				foreach ($_post as $post){
					
					$image = get_the_post_thumbnail_url($post->ID, 'full');
				
				?>
					<?php if ($post_per_page < 4) : ?>
					<div class="grid-item col-xs-12 col-sm-4 col-md-4">
					<?php else: ?>
					<div class="grid-item col-xs-12 col-sm-2 col-md-2">
					<?php endif; ?>
						<div class="grid-content">
							<a class="grid-href" href="<?php echo get_permalink($post->ID);?>" target="_blank" >
								<span class="grid-bg" style="background-image:url(<?php echo $image; ?>);"></span>
								<span class="grid-title"><?php echo $post->post_title; ?></span>
								<span class="grid-date"><?php echo get_the_time('F Y', $post->ID);?></span>
							</a>
						</div>

					</div>
				<?php 
				}
				?>
				
				<?php 
		?>
					</div>
				</div>
				<?php if ($post_per_page < 4) :?>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="col-sm-6 col-md-6">
						<ul>
							<li>
								<p><a href="">Corporate/M&A</a></p>
								<p><span>Giugno 208</span></p>
							</li>
							<li>
								<p><a href="">Amministrativo</a></p>
								<p><span>Aprile 208</span></p>
							</li>
							<li>
								<p><a href="">Lavoro</a></p>
								<p><span>Febbraio 208</span></p>
							</li>
							<li>
								<p><a href="">Tecnology Media Telecom</a></p>
								<p><span>Febbraio 208</span></p>
							</li>
						</ul>
					</div>
					<div class="col-sm-6 col-md-6">
						<ul>
							<li>
								<p><a href="">Corporate/M&A</a></p>
								<p><span>Giugno 208</span></p>
							</li>
							<li>
								<p><a href="">Amministrativo</a></p>
								<p><span>Aprile 208</span></p>
							</li>
							<li>
								<p><a href="">Lavoro</a></p>
								<p><span>Febbraio 208</span></p>
							</li>
							<li>
								<p><a href="">Tecnology Media Telecom</a></p>
								<p><span>Febbraio 208</span></p>
							</li>
						</ul>
					</div>
				</div>
			<?php endif; ?>
			</div>
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
		$instance['per_page']   = strip_tags( $new_instance['per_page'] );
		
		return $instance;
	}


	/*-----------------------------------------------------------------------------------*/
	/*	Widget Settings
    /*-----------------------------------------------------------------------------------*/

	function form( $instance ) {
		/* Set up some default widget settings. */
		$defaults = array(
			'per_page'	=> 3
		);

		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
		<p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'per_page' ) ); ?>"><?php _e( 'Number of posts:', 'tecnavia' ) ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'per_page' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'per_page' ) ); ?>"
                   value="<?php echo esc_attr( $instance['per_page'] ); ?>"/>
        </p>
		<?php
	}

}