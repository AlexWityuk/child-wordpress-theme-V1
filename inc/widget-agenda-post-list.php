<?php

// Register Post List widget.
add_action( 'widgets_init', function () {
	register_widget( 'Agenda_Post_List_Widget' );
} );

// Widget class.
class Agenda_Post_List_Widget extends WP_Widget {

	/*-----------------------------------------------------------------------------------*/
	/*	Widget Setup
	/*-----------------------------------------------------------------------------------*/

	public function __construct() {
		parent::__construct(
			'agenda_post_list_widget',        // Base ID
			'Agenda post - list',        // Name
			array( 'description' => __( 'Display Popular Posts in a list', 'tecnavia' ) )
		);

		/*-------------------------Add Wp Color Picker---------------------------------------------------*/
        // This is where we add the style and script
        add_action( 'load-widgets.php', array( $this, 'tecnavia_colorPicker_load') );
        add_action( 'admin_footer-widgets.php', array( $this, 'print_scripts' ), 9999 );

        /*-------------------------Add Wp Color Picker---------------------------------------------------*/
	}


	function tecnavia_colorPicker_load() {    
        wp_enqueue_style( 'wp-color-picker' );        
        wp_enqueue_script( 'wp-color-picker' );    
    }


  	public function print_scripts() {
      	?>
      	<script>
        	( function( $ ){
          		function initColorPicker( widget ) {
            		widget.find( '.color-picker' ).wpColorPicker( {
              			change: _.throttle( function() { // For Customizer
                			$(this).trigger( 'change' );
              			}, 3000 )
        			});
      			}

		      	function onFormUpdate( event, widget ) {
		            initColorPicker( widget );
		      	}

      			$( document ).on( 'widget-added widget-updated', onFormUpdate );

		  		$( document ).ready( function() {
		            $( '#widgets-right .widget:has(.color-picker)' ).each( function () {
		              	initColorPicker( $( this ) );
		            } );
		      	} );
        	}( jQuery ) );
      	</script>
      	<?php
    }


	/*-----------------------------------------------------------------------------------*/
	/*	Display Widget
    /*-----------------------------------------------------------------------------------*/

	function widget( $args, $instance ) {

		extract( $args, EXTR_SKIP );
		$bgcolor = isset( $instance['background_color'] ) ? $instance['background_color'] : '#1f1f1f';
		$number_of = isset( $instance['number_of'] ) ? (int) $instance['number_of'] : 1;
		$mix_posts_number = isset( $instance['mix_posts_number'] ) ? (int) $instance['mix_posts_number'] : 6;

		echo $args['before_widget'];

		
		$terms = get_terms( 'agenda-type', array(
				'hide_empty' => true,
		) );
		?>
		<div class="agenda-list-wrap" style="background: <?php  echo $bgcolor; ?>;">
			<div class="row <?php  echo 'number_of_'. $number_of; ?>">
		<?php 
		/*-------------------------------Get agenda posts by tipo-------------------------------*/
		$agenda_posts = array();
		//var_dump($terms);
		//echo "</br>";
		foreach ($terms as $t) {
			
			$args = array(
				'posts_per_page' => $number_of, 
				'post_type' => 'agenda',
				'tax_query' => array(
						array(
							'taxonomy' => 'agenda-type',
							'field' => 'term_id',
							'terms' => $t->term_id
						)
				)
			);
			
			$_posts = get_posts( $args );
			
			//var_dump(count($_posts));
			//echo "<br/>";
			
			if (count($_posts) <= 0 )
				continue;
			
			$image = get_term_meta($t->term_id, "default_image", true);	

			foreach ($_posts as $_post) {
				$_post = $_post->to_array();
				$_post['thumbnail'] = get_term_meta($t->term_id, "default_image", true);	
				$agenda_posts[$_post['ID']] = $_post;
			}
		}
		//var_dump($agenda_posts);
		//echo "<br/>*********************************<br/>";
		/*--------------------Get external Events from the list----------------------------------*/
			$event_posts = get_option('externalpost');
			$event_posts = json_decode(json_encode($event_posts), true);
			//var_dump($event_posts);
			//wp_die();
		/*---------------------------------------------------------------------------------------*/
	 	$_posts = array_merge($agenda_posts, $event_posts);
	 	/*----------------------Sort $_posts array by post_date------------------------------------*/
	 	$inventory = array();
		foreach ($_posts as $key => $row)
		{
		    $inventory[$key] = $row['post_date'];
		}
		array_multisort($inventory, SORT_DESC, $_posts);
		array_splice($_posts, $mix_posts_number);
		//var_dump(count($_posts));
	 	/*----------------------------------------------------------------------------------*/
		/*
		foreach ($_posts as $key => $value) {
			var_dump($key,$value);
			echo "<br/><br/>*********<br/><br/>";
		}
		*/
		//var_dump($_posts);
		//wp_die();
		/*---------------------------------------------------------------------------------------*/
		if (!empty( $_posts )) {

			foreach ( $_posts as $_post ) {	
				$url = get_permalink($_post['ID']);
				if (isset($_post['url'])) $url = $_post['url'];
			?>
				<div class="agenda-list-item">
					<!--<div class="col-md-8 col-sm-12 col-xs-12 no-padding-left">-->
					<div class="col-md-7 col-sm-7 col-xs-8 no-padding-right">
						<a href="<?php echo $url; ?>">
							<?php echo $_post['post_title']; ?>
						</a>
					</div>
					<!--<div class="col-md-4 hidden-sm hidden-xs">-->
					<div class="col-md-5 col-sm-5 col-xs-4 no-padding-left">
						<a style="background-image:url(<?php echo $_post ['thumbnail']; ?>);" class="img-wrap" href="<?php echo $url; ?>">
							<?php echo $_post['post_title']; ?>
						</a>
					</div>
					<div style="clear: both;"></div>
				</div>
			<?php 
			}
		}
		?>
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
        $instance = $new_instance;
        $instance['background_color'] = strip_tags($new_instance['background_color']);
        $instance['number_of'] = strip_tags( $new_instance['number_of'] );
        $instance['mix_posts_number'] = strip_tags( $new_instance['mix_posts_number'] );
        return $instance;
	}


	/*-----------------------------------------------------------------------------------*/
	/*	Widget Settings
    /*-----------------------------------------------------------------------------------*/

	/*function form( $instance ) {

		
	}*/
    function form($instance) {
        $defaults = array(
            'background_color' => '#ececec',
            'number_of' => '1',
            'mix_posts_number' => 6
        );

        // Merge the user-selected arguments with the defaults
        $instance = wp_parse_args( (array) $instance, $defaults ); ?>

        <p>
            <label for="<?php echo $this->get_field_id( 'background_color' ); ?>"><?php _e( 'Background Color'); ?></label>
            <input class="color-picker" type="text" id="<?php echo $this->get_field_id( 'background_color' ); ?>" name="<?php echo $this->get_field_name( 'background_color' ); ?>" value="<?php echo esc_attr( $instance['background_color'] ); ?>" />                            
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
		<p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'mix_posts_number' ) ); ?>"><?php _e( 'Number of total mixed posts in the Agenda section:', 'tecnavia' ) ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'mix_posts_number' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'mix_posts_number' ) ); ?>"
                   value="<?php echo esc_attr( $instance['mix_posts_number'] ); ?>"/>
        </p>
        <?php
    }
}