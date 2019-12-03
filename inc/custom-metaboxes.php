<?php
/**
 * Custom metaboxes
 *
 * @package Tecnavia
 */

add_action( 'add_meta_boxes', 'toplegal_add_meta_box', 1 );

function toplegal_add_meta_box () {
	/*--------------------------------------------------------------------*/
	/*   the metabox for "Guida" post-type
	/*   adds the date Month and Year
	/*--------------------------------------------------------------------*/
	add_meta_box( 'add-date-month-year', 'Mese e Anno:', 'add_guida_date_box_field', 'guida', 'normal', 'high' );
	/*--------------------------------------------------------------------*/
	/*   the metabox for "Guida items" post-type
	/*   Create the table with the lict of the "guida_items" post-type
	/*--------------------------------------------------------------------*/
	add_meta_box( 'add-date-list-guida-items', 'Guida Items', 'add_guida_items_list_table_box_field', 'guida', 'normal', 'high' );
	add_meta_box( 'bind-to-guida', 'Bound to Guida', 'bind_to_guida_box_field', 'guida_item', 'side', 'low' );
	add_meta_box( 'guida-items-directory', 'External guida items list', 'guida_items_directory_box_field', 'guida_item', 'side', 'low' );
	add_meta_box( 'white-papers-bind-to-external-guida-items', 'Bind to the External guida item', 'white_papers_bind_to_external_guida_items_box_field', 'white_paper', 'side', 'low' );
}

function add_guida_date_box_field ($post) {
	wp_nonce_field( basename(__FILE__), 'guida_manth_year_mam_nonce' );
	$manth = maybe_unserialize( get_post_meta( $post->ID, 'guida-month', true ) );
	$year = maybe_unserialize( get_post_meta( $post->ID, 'guida-year', true ) );

	$months = array(
		            'gennaio', 
		            'febbraio',
		            'marzo',
		            'aprile',
		            'maggio',
		            'giugno',
		            'luglio',
		            'agosto',
		            'settembre',
		            'ottobre',
		            'novembre',
		            'dicembre'
		            );
	?>
	<style type="text/css">
	/*#select_media_file_event .inside {
	    overflow: hidden;
	}*/
	</style>
	<select name="guida-manths" id="guida-manths" class="testo_modulo" style="font-size:12px;">
		<?php for ($i=0; $i < count($months); $i++) :?>
				<option <?php selected( $manth, $i ); ?> value="<?php echo $i; ?>"><?php echo $months[$i]; ?></option>
		<?php endfor; ?>
	</select>
	<input type="text" id="guida-year" name="guida-year" value="<?php echo $year; ?>"/>
	<?php
}
function add_guida_date_save_data ($post_id) {
	$is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'guida_manth_year_mam_nonce' ] ) && wp_verify_nonce( $_POST[ 'guida_manth_year_mam_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

    if ( ! empty( $_POST['guida-year'] ) ) {
        update_post_meta( $post_id, 'guida-month', $_POST['guida-manths'] );
        update_post_meta( $post_id, 'guida-year', $_POST['guida-year'] );
    } else {
        delete_post_meta( $post_id, 'guida-month' );
        delete_post_meta( $post_id, 'guida-year' );
    }

}
add_action('save_post', 'add_guida_date_save_data');

function add_guida_items_list_table_box_field ($post) {
	global $post;
	//wp_nonce_field( basename(__FILE__), 'guida_items_list_table_mam_nonce' );
	$direct = maybe_unserialize( get_post_meta( $post->ID, 'guida-studio-professionista', true ) );
	//var_dump($direct);
	$myListTable = new Guida_Items_List_Table();
    $myListTable->prepare_items();
    ?>
    <div class="wrap">
    	<h1 class="wp-heading-inline">Guida Items</h1>
    	<a href="/toplegal/news/wp-admin/wp-admin/post-new.php?post_type=guida_item&guida-slug=<?php echo $post->post_name; ?>" class="page-title-action">Add New</a>       
        <div style="height:10px;"></div>
        <div>
        	<div style="width: 200px; float: left;">
        		<select name="guida-action" id="bulk-action-selector-top">
					<option value="balk-actions">Bulk Actions</option>
					<option value="delete">Delete</option>
				</select>
        	</div>
        	<div style="width: 300px; margin-left:20px;">
        		<select name="studio-professionista">
        			<option value="all" <?php selected( $direct, 'all' ) ?>>All</option>
					<option value="studio" <?php selected( $direct, 'studio' ) ?>>Studi legali</option>
					<option value="professionista" <?php selected( $direct, 'professionista' ) ?>>Professionisti</option>
				</select>
        	</div>
        </div>
        <div id="guida-items-posts">
			<?php //$myListTable->search_box('search', 'search_id'); ?>
            <?php $myListTable->display() ?>
            <p style="margin: 30px"></p>
        </div>
    </div>
    <?php
}
function add_guida_items_list_table_save_data ($post_id) {
	$is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'guida_items_list_table_mam_nonce' ] ) && wp_verify_nonce( $_POST[ 'guida_items_list_table_mam_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
    // If the checkbox was not empty, save it as array in post meta
    if ( ! empty( $_POST['guid-items'] ) ) {

    	foreach ($_POST['guid-items'] as $id) {
			wp_delete_post( (int)$id );
    	}
        //update_post_meta( $post_id, 'guida_items_list_table_delet_id', $_POST['guid-items'] );
    }
    if ( ! empty( $_POST['studio-professionista'] ) ) {
    	update_post_meta( $post_id, 'guida-studio-professionista', $_POST['studio-professionista'] );
    }
}
add_action('save_post', 'add_guida_items_list_table_save_data');

function bind_to_guida_box_field ($post) {
	wp_nonce_field( basename(__FILE__), 'bind_to_guida_mam_nonce' );
	$guida_slug = maybe_unserialize( get_post_meta( $post->ID, 'bind-to-guida-slug', true ) );
	//var_dump($guida_slug);
	if ($guida_slug !='') :
	$args = array(
	  'name'        => $guida_slug,
	  'post_type'   => 'guida'
	);
	$guidas = get_posts($args);
	//var_dump($guidas);
	?>
		<p>
			<input type="hidden" id="bind-to-guida-post"
			       name="bind-to-guida-post"
			       value="<?php echo $guida_slug; ?>"/>
		</p>
		<p><a href="http://testwp23.newsmemory.com/toplegal/news/wp-admin/post.php?post=<?php echo $guidas[0]->ID; ?>&action=edit"><?php echo $guidas[0]->post_title; ?></a></p>
	<?php
	else:?>
	<p>Put the slug of the "Guida" post</p>
			<input type="text" id="bind-to-guida-post"
			       name="bind-to-guida-post"
			       value=""/>
	<?php
	endif;
}

function bind_to_guida_save_data ($post_id) {
	$is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'bind_to_guida_mam_nonce' ] ) && wp_verify_nonce( $_POST[ 'bind_to_guida_mam_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
    if (isset($_GET['guida-slug'])) {
    	update_post_meta( $post_id, 'bind-to-guida-slug', $_GET['guida-slug'] );
    }
    elseif ( ! empty( $_POST['bind-to-guida-post'] ) ) {
        update_post_meta( $post_id, 'bind-to-guida-slug', $_POST['bind-to-guida-post'] );
    } else {
        delete_post_meta( $post_id, 'bind-to-guida-slug' );
    }
}
add_action('save_post', 'bind_to_guida_save_data');

function guida_items_directory_box_field($post) {
	wp_nonce_field( basename(__FILE__), 'guida_items_directory_mam_nonce' );
	$directory = maybe_unserialize( get_post_meta( $post->ID, 'guida-items-directory', true ) );
	$extrn_name_studio  = maybe_unserialize( get_post_meta( $post->ID, 'guida-items-external-id', true ) );
	$extrn_id_studio  = maybe_unserialize( get_post_meta( $post->ID, 'guida-items-external-id-hidden', true ) );
	$extrn_name_professionista  = maybe_unserialize( get_post_meta( $post->ID, 'guida-items-external-id-professionista', true ) );
	$extrn_id_professionista  = maybe_unserialize( get_post_meta( $post->ID, 'guida-items-external-id-professionista-hidden', true ) );
	/*
	$output = maybe_unserialize( get_post_meta( $post->ID, 'search_result_for_the_guida_item', true ) );
	$output_professionista = maybe_unserialize( get_post_meta( $post->ID, 'search_result_for_the_guida_item_professionista', true ) );
	$output = json_decode($output,true);
	$output_professionista = json_decode($output_professionista,true);
	*/
?>
	<div class="ui-widget">
		Directory:
   		<select id="guida-items-directory" name="guida-items-directory" style="width: 100%;">
			<option value="studio" <?php selected( $directory, 'studio' ) ?>>Studio</option>
			<option value="professionista" <?php selected( $directory, 'professionista' ) ?>>Professionisti</option>
		</select>
	</div>
	<?php //if ( $directory == 'professionista' ): ?>
	<div class="ui-widget" id="ui-professionista" style="margin-top:2em; font-family:Arial; position relative;">
		Professionista:
		<div style="position: relative;">
			<input type="hidden" id="guida-item-external-id-professionista-hidden" name="guida-item-external-id-professionista-hidden" value="<?php echo $extrn_id_professionista; ?>">
			<input class="search-extrnal-items" type="text" post-type="professionista" id="guida-item-external-id-professionista" 
			name="guida-item-external-id-professionista" value="<?php echo $extrn_name_professionista; ?>" style="width: 92%; float: left; padding: 2px 5px; margin: 0px;" autocomplete="off"/>
			<div class="rcbArrowCell rcbArrowCellRight">
				<a id="professionista-show-result-arrow" style="overflow: hidden;display: block;position: relative;outline: none;">select</a>
			</div>
		</div>
	  	<div id="log-professionista" style="width: 99%; overflow: auto;" class="log ui-widget-content">
	  		<div class="items-st-prof" id="items-professionista" style="height: 200px; width: 100%; overflow: auto; border: 0px solid #666;">
		  		<?php //foreach ($output_professionista as $value): ?>
		  			<div class="search-result-list"><a href="" id="<?php echo $extrn_id_professionista /*$value['id']*/; ?>"><?php echo $extrn_name_professionista/*$value['first_name'].' '.$value['last_name']*/; ?></a></div>
		  		<?php //endforeach; ?>
	  		</div>
	  		<div class="rcbMoreResults" style="cursor: default;">
	  			<a id="professionista">select</a>
	  			<span></span>
	  		</div>
	  		<div class="loader" style="height: 200px;"></div>
	  	</div>
	</div>
	<?php //endif; ?>
	<div class="ui-widget" style="margin-top:2em; font-family:Arial; position relative;">
		Studio:
		<div style="position: relative;">
			<input type="hidden" id="guida-item-external-id-studio-hidden" name="guida-item-external-id-studio-hidden" value="<?php echo $extrn_id_studio; ?>">
			<input class="search-extrnal-items" type="text" post-type="studio" id="guida-item-external-id-studio" 
			name="guida-item-external-id-studio" value="<?php echo $extrn_name_studio; ?>" style="width: 92%; float: left; padding: 2px 5px; margin: 0px;" autocomplete="off"/>
			<div class="rcbArrowCell rcbArrowCellRight">
				<a id="studio-show-result-arrow" style="overflow: hidden;display: block;position: relative;outline: none;">select</a>
			</div>
		</div>
	  	<div id="log-studio" style="width: 99%; overflow: auto;" class="log ui-widget-content">
	  		<div class="items-st-prof" id="items-studio" style="height: 200px; width: 100%; overflow: auto; border: 0px solid #666;">
		  		<?php //foreach ($output as $value): ?>
		  			<div class="search-result-list"><a href="" id="<?php echo $extrn_id_studio/*$value['id']*/; ?>"><?php echo $extrn_name_studio/*$value['name']*/; ?></a></div>
		  		<?php //endforeach; ?>
	  		</div>
	  		<div class="rcbMoreResults" style="cursor: default;">
	  			<a id="studio">select</a>
	  			<span></span>
	  		</div>
	  		<div class="loader" style="height: 200px;"></div>
	  	</div>
	</div>
<?php
}
function guida_items_directory_save_data ($post_id) {
	$is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'guida_items_directory_mam_nonce' ] ) && wp_verify_nonce( $_POST[ 'guida_items_directory_mam_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

    if ( ! empty( $_POST['guida-items-directory'] ) ) {
        update_post_meta( $post_id, 'guida-items-directory', $_POST['guida-items-directory'] );
    } else {
        delete_post_meta( $post_id, 'guida-items-directory' );
    }

    if ( ! empty( $_POST['guida-item-external-id-studio'] ) ) {
        update_post_meta( $post_id, 'guida-items-external-id', $_POST['guida-item-external-id-studio'] ); //For the storing the external name
        update_post_meta( $post_id, 'guida-items-external-id-hidden', $_POST['guida-item-external-id-studio-hidden'] ); //For the storing the external ID
        /*
        $type = 'studio';
        $search_word = $_POST['guida-item-external-id-studio'];
        $output = search_admin_stui_for_professionista ($type, $search_word);
        update_post_meta( $post_id, 'search_result_for_the_guida_item', $output);
        */
    } else {
        delete_post_meta( $post_id, 'guida-items-external-id' );
    }

    if ( ! empty( $_POST['guida-item-external-id-professionista'] ) ) {
        update_post_meta( $post_id, 'guida-items-external-id-professionista', $_POST['guida-item-external-id-professionista'] ); //For the storing the external name
        update_post_meta( $post_id, 'guida-items-external-id-professionista-hidden', $_POST['guida-item-external-id-professionista-hidden'] ); //For the storing the external ID
        /*
        $type = 'professionista';
        $search_word = $_POST['guida-item-external-id-professionista'];
        $output_professionista = search_admin_stui_for_professionista ($type, $search_word);
        update_post_meta( $post_id, 'search_result_for_the_guida_item_professionista', $output_professionista);
        */
    } else {
        delete_post_meta( $post_id, 'guida-items-external-id-professionista' );
        delete_post_meta( $post_id, 'search_result_for_the_guida_item_professionista' );
    }
}
add_action('save_post', 'guida_items_directory_save_data');

/*function search_admin_stui_for_professionista ($type, $search_word) {
			// create curl resource
		$ch = curl_init();
		$search_word = str_replace("&","&amp;",$search_word);
		// set url
	  	//curl_setopt($ch, CURLOPT_URL, sprintf("http://82.220.53.74:3000/api/toplegal/contacts?type[]=%s&q=%s", "studio",  $search_word ));
	  	if ( $type == "studio")
	  	curl_setopt($ch, CURLOPT_URL, sprintf("https://crm.newsmemory.com:8143/api/toplegal/contacts?type[]=%s&q=%s", "studio",  $search_word ));
		else
	  	curl_setopt($ch, CURLOPT_URL, sprintf("https://crm.newsmemory.com:8143/api/toplegal/contacts?type[]=%s&q=%s", "professionista",  $search_word ));
	  	//curl_setopt($ch, CURLOPT_URL, "https://crm.newsmemory.com:8143/api/toplegal/contacts?link=" . urlencode("wind"));


		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJjbGllbnRfYXBwIjoidG9wbGVnYWxfd29yZHByZXNzIn0.4pZlmokVU3P5J1I415a9OUR1oE2w8PhZRiB7O1dmH-k'
		));

		//return the transfer as a string
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		// $output contains the output string
		$output = curl_exec($ch);

		curl_close($ch);
		return $output;
}*/

/*
* Are the White Paper ( diritto az ) that is necessary bind to the Studio / Professionista 
* using the same external service with the same component used inside guida item.
*
*/
function white_papers_bind_to_external_guida_items_box_field ($post) {
	wp_nonce_field( basename(__FILE__), 'white_paper_directory_mam_nonce' );
	$directory = maybe_unserialize( get_post_meta( $post->ID, 'white-paper-directory', true ) );
	$extrn_name_studio  = maybe_unserialize( get_post_meta( $post->ID, 'white-paper-external-id', true ) );
	$extrn_id_studio  = maybe_unserialize( get_post_meta( $post->ID, 'white-paper-external-id-hidden', true ) );
	$extrn_name_professionista  = maybe_unserialize( get_post_meta( $post->ID, 'white-paper-external-id-professionista', true ) );
	$extrn_id_professionista  = maybe_unserialize( get_post_meta( $post->ID, 'white-paper-external-id-professionista-hidden', true ) );
?>
	<div class="ui-widget">
		Directory:
   		<select id="guida-items-directory" name="guida-items-directory" style="width: 100%;">
			<option value="studio" <?php selected( $directory, 'studio' ) ?>>Studio</option>
			<option value="professionista" <?php selected( $directory, 'professionista' ) ?>>Professionisti</option>
		</select>
	</div>
	<?php //if ( $directory == 'professionista' ): ?>
	<div class="ui-widget" id="ui-professionista" style="margin-top:2em; font-family:Arial; position relative;">
		Professionista:
		<div style="position: relative;">
			<input type="hidden" id="guida-item-external-id-professionista-hidden" name="guida-item-external-id-professionista-hidden" value="<?php echo $extrn_id_professionista; ?>">
			<input class="search-extrnal-items" type="text" post-type="professionista" id="guida-item-external-id-professionista" 
			name="guida-item-external-id-professionista" value="<?php echo $extrn_name_professionista; ?>" style="width: 92%; float: left; padding: 2px 5px; margin: 0px;" autocomplete="off"/>
			<div class="rcbArrowCell rcbArrowCellRight">
				<a id="professionista-show-result-arrow" style="overflow: hidden;display: block;position: relative;outline: none;">select</a>
			</div>
		</div>
	  	<div id="log-professionista" style="width: 99%; overflow: auto;" class="log ui-widget-content">
	  		<div class="items-st-prof" id="items-professionista" style="height: 200px; width: 100%; overflow: auto; border: 0px solid #666;">
		  		<?php //foreach ($output_professionista as $value): ?>
		  			<div class="search-result-list"><a href="" id="<?php echo $extrn_id_professionista /*$value['id']*/; ?>"><?php echo $extrn_name_professionista/*$value['first_name'].' '.$value['last_name']*/; ?></a></div>
		  		<?php //endforeach; ?>
	  		</div>
	  		<div class="rcbMoreResults" style="cursor: default;">
	  			<a id="professionista">select</a>
	  			<span></span>
	  		</div>
	  		<div class="loader" style="height: 200px;"></div>
	  	</div>
	</div>
	<?php //endif; ?>
	<div class="ui-widget" style="margin-top:2em; font-family:Arial; position relative;">
		Studio:
		<div style="position: relative;">
			<input type="hidden" id="guida-item-external-id-studio-hidden" name="guida-item-external-id-studio-hidden" value="<?php echo $extrn_id_studio; ?>">
			<input class="search-extrnal-items" type="text" post-type="studio" id="guida-item-external-id-studio" 
			name="guida-item-external-id-studio" value="<?php echo $extrn_name_studio; ?>" style="width: 92%; float: left; padding: 2px 5px; margin: 0px;" autocomplete="off"/>
			<div class="rcbArrowCell rcbArrowCellRight">
				<a id="studio-show-result-arrow" style="overflow: hidden;display: block;position: relative;outline: none;">select</a>
			</div>
		</div>
	  	<div id="log-studio" style="width: 99%; overflow: auto;" class="log ui-widget-content">
	  		<div class="items-st-prof" id="items-studio" style="height: 200px; width: 100%; overflow: auto; border: 0px solid #666;">
		  		<?php //foreach ($output as $value): ?>
		  			<div class="search-result-list"><a href="" id="<?php echo $extrn_id_studio/*$value['id']*/; ?>"><?php echo $extrn_name_studio/*$value['name']*/; ?></a></div>
		  		<?php //endforeach; ?>
	  		</div>
	  		<div class="rcbMoreResults" style="cursor: default;">
	  			<a id="studio">select</a>
	  			<span></span>
	  		</div>
	  		<div class="loader" style="height: 200px;"></div>
	  	</div>
	</div>
<?php
}
function white_paper_directory_save_data ($post_id) {
	$is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'white_paper_directory_mam_nonce' ] ) && wp_verify_nonce( $_POST[ 'white_paper_directory_mam_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

    if ( ! empty( $_POST['guida-items-directory'] ) ) {
        update_post_meta( $post_id, 'white-paper-directory', $_POST['guida-items-directory'] );
    } else {
        delete_post_meta( $post_id, 'white-paper-directory' );
    }

    if ( ! empty( $_POST['guida-item-external-id-studio'] ) ) {
        update_post_meta( $post_id, 'white-paper-external-id', $_POST['guida-item-external-id-studio'] ); //For the storing the external name
        update_post_meta( $post_id, 'white-paper-external-id-hidden', $_POST['guida-item-external-id-studio-hidden'] ); //For the storing the external ID
        /*
        $type = 'studio';
        $search_word = $_POST['guida-item-external-id-studio'];
        $output = search_admin_stui_for_professionista ($type, $search_word);
        update_post_meta( $post_id, 'search_result_for_the_guida_item', $output);
        */
    } else {
        delete_post_meta( $post_id, 'white-paper-external-id' );
    }

    if ( ! empty( $_POST['guida-item-external-id-professionista'] ) ) {
        update_post_meta( $post_id, 'white-paper-external-id-professionista', $_POST['guida-item-external-id-professionista'] ); //For the storing the external name
        update_post_meta( $post_id, 'white-paper-external-id-professionista-hidden', $_POST['guida-item-external-id-professionista-hidden'] ); //For the storing the external ID
        /*
        $type = 'professionista';
        $search_word = $_POST['guida-item-external-id-professionista'];
        $output_professionista = search_admin_stui_for_professionista ($type, $search_word);
        update_post_meta( $post_id, 'search_result_for_the_guida_item_professionista', $output_professionista);
        */
    } else {
        delete_post_meta( $post_id, 'white-paper-external-id-professionista' );
    }
}
add_action('save_post', 'white_paper_directory_save_data');
?>