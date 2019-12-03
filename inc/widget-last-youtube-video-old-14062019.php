<?php

// Register Homepage Second Block Posts widget.
add_action( 'widgets_init', function () {
	register_widget( 'Last_Youtube_Video' );
} );

// Widget class.
class Last_Youtube_Video extends WP_Widget {

	/*-----------------------------------------------------------------------------------*/
	/*	Widget Setup
	/*-----------------------------------------------------------------------------------*/

	public function __construct() {
		parent::__construct(
			'last_youtube_video_list',        // Base ID
			__( 'Last youtube video list', 'tecnavia' ),        // Name
			array( 'description' => __( 'Display last video from youtube channel', 'tecnavia' ) )
		);
	}


	/*-----------------------------------------------------------------------------------*/
	/*	Display Widget
    /*-----------------------------------------------------------------------------------*/

	function widget( $args, $instance ) {
		
		
		
		$number_of = isset( $instance['number_of'] ) ? (int) $instance['number_of'] : 4;
		$title = isset( $instance['title'] ) ? $instance['title'] : '';

		echo $args['before_widget'];
	?>
		<!--<div class="block" style="    margin-bottom: 20px;">
            <div class="title">
                <ul class="icon">
                    <li><i class="fa fa-camera" aria-hidden="true"></i></li>
                </ul>
                <div class="name">
                    <h4><?php //echo $title; ?></h4>
                </div>
            </div>
		</div>-->
		<div class="youtube-list-wrap">	
		<?php
		//$videos          = getYoutubeVideo(3);
		//$video_page_path = tecnavia_get_page_path_by_template( 'video-template.php' );

		//if (isset($videos)) :
		//foreach ( $videos as $video ) :
		?>			
			<div class="grid-item col-xs-12  col-sm-4 col-md-4 no-padding-left">
				<div class="grid-content">
					<a class="grid-href" href="https://www.youtube.com/watch?v=G9qpGJ-bh8c" target="_blank" >
						<span class="grid-bg" style="background-image:url(https://img.youtube.com/vi/G9qpGJ-bh8c/hqdefault.jpg);"></span>
						<span class="grid-title">3.TopLegal Awards 2017 – I commenti a caldo dei vincitori - Premi settore Squadre</span>
					</a>
				</div>
			</div>
			<div class="grid-item col-xs-12  col-sm-4 col-md-4 ">
				<div class="grid-content">
					<a class="grid-href" href="https://www.youtube.com/watch?v=r1ToopkUS5s" target="_blank" >
						<span class="grid-bg" style="background-image:url(https://img.youtube.com/vi/r1ToopkUS5s/hqdefault.jpg);"></span>
						<span class="grid-title">Jeffrey Greenbaum, Hogan Lovells - TopLegal Awards 2017</span>
					</a>
				</div>
			</div>		
			<!--<div class="grid-item col-md-4 ">
				<div class="grid-content">
					<a class="grid-href" href="<?php echo $video_page_path; ?>" target="_blank" >
						<span class="grid-bg" style="background-image:url(<?php print $video['image']; ?>);"></span>
						<span class="grid-title"><?php echo $video['title']; ?></span>
					</a>
				</div>
			</div>-->	
			<div class="grid-item col-xs-12  col-sm-4 col-md-4  no-padding-right">
				<div class="grid-content">
					<a class="grid-href" href="https://www.youtube.com/watch?v=qCvbZkj-e-0" target="_blank" >
						<span class="grid-bg" style="background-image:url(https://img.youtube.com/vi/qCvbZkj-e-0/hqdefault.jpg);"></span>
						<span class="grid-title">Roberto Valenti, DLA Piper - TopLegal Awards 2017</span>
					</a>
				</div>
			</div>
	<?php 
		//endforeach;
		//endif;
		?>
			<div style="clear:both;"></div>
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
		$instance['number_of'] = strip_tags( $new_instance['number_of'] );
		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	}


	/*-----------------------------------------------------------------------------------*/
	/*	Widget Settings
    /*-----------------------------------------------------------------------------------*/

	function form( $instance ) {
		/* Set up some default widget settings. */
		$defaults = array(
			'number_of' => '4',
			'title' => ''
		);

		$instance = wp_parse_args( (array) $instance, $defaults );
		?>


        <p>
            <label
                    for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'tecnavia' ) ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
                   value="<?php echo esc_attr( $instance['title'] ); ?>"/>
        </p>
        <p>
            <label
                    for="<?php echo esc_attr( $this->get_field_id( 'number_of' ) ); ?>"><?php _e( 'How many video do you want to display?', 'tecnavia' ) ?></label>
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