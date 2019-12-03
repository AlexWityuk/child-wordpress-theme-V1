<?php
if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class Guida_Items_List_Table extends WP_List_Table {
	function get_columns() {
	  	$columns = array(
	  		'cb'        => '<p><input type="checkbox" />',
		    'title' => 'Title'
	  	);
	  	return $columns;
	}
    function column_cb($item){
        return '<input type="checkbox" name="guid-items[]" value="'.$item->ID.'"/>';
    }

	function column_default($item, $column_name)
	{
		switch ($column_name) {
			case 'title':
				return $item->$column_name;
			default:
				return "col name = $column_name ," . print_r($item, true);
		}
	}
    function column_title($item){   
        return sprintf('<a href="/toplegal/news/wp-admin/post.php?post=%1$s&action=edit">%2$s</a>',
            /*$1%s*/ $item->ID,
            /*$2%s*/ $item->post_title
        );
    }
	public function prepare_items() {
     	/*------------------------------------------------------------------------------------------*/
      global $post;
      global $wp_query;
      $post_slug = $post->post_name;
      $arg = array();
      $direct = maybe_unserialize( get_post_meta( $post->ID, 'guida-studio-professionista', true ) );
      //var_dump($direct,$post->ID);
      if ( $direct == 'all' ) {
        $arg = array(
          'post_type'        => 'guida_item',
          'posts_per_page'   => -1,
          'meta_key'         =>  'bind-to-guida-slug',
          'meta_value'       =>   $post_slug
        ); 
      } else {
        $arg = array(
          'post_type'        => 'guida_item',
          'posts_per_page'   => -1,
          'meta_query' => array(
            'relation' => 'AND',
            array(
              'key' => 'guida-items-directory',
              'value' => $direct
            ),
            array(
              'key' => 'bind-to-guida-slug',
              'value' => $post_slug
            ),
          )
        ); 
      }
     $wp_query = new WP_Query( $arg );
      $data = $wp_query->posts;
     	/*------------------------------------------------------------------------------------------*/

      /*----------------------------------------------------------------------*/
      /* Pagination
      /*-----------------------------------------------------------------------*/
        $per_page = -1;//10;
        $current_page = $this->get_pagenum();
        //var_dump($current_page);
        $total_items = count($data);

        // only ncessary because we have sample data
        $found_data = array_slice($data,(($current_page-1)*$per_page),$per_page);
//var_dump($found_data);
        $this->set_pagination_args( array(
          'total_items' => $total_items,                  //WE have to calculate the total number of items
          'per_page'    => $per_page                     //WE have to determine how many items to show on a page
        ) );
        //$data = $found_data;
              //$wp_query->max_num_pages = ceil ( $wp_query->found_posts/($per_page) );
      /*-----------------------------------------------------------------------*/
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = array();
        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $data; //$found_data;
        //$this->process_bulk_action();
        //tecnavia_pagination();
	}
  function display_tablenav () {}
  /*function get_bulk_actions() {
    $actions = array(
      'delete'    => 'Delete'
    );
    return $actions;
  }
  function process_bulk_action() {        
    $action = $this->current_action();
    if( $action === 'delete' ) {
      wp_die('Items deleted (or they would be if we had items to delete)!');
    }        
  }*/
    /*----------------------------------------------------------*/
}