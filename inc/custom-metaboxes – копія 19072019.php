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
	add_meta_box( 'bind-to-guida', 'Binded to Guida', 'bind_to_guida_box_field', 'guida_item', 'side', 'low' );
	add_meta_box( 'guida-items-directory', 'Directory', 'guida_items_directory_box_field', 'guida_item', 'side', 'low' );
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
	<p>Add the slug of the "Guida" post</p>
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
	$extrn_id  = maybe_unserialize( get_post_meta( $post->ID, 'guida-items-external-id', true ) );
?>
	<div class="ui-widget">
   		<select id="guida-items-directory" name="guida-items-directory" style="width: 100%;">
			<option value="studio" <?php selected( $directory, 'studio' ) ?>>Studio</option>
			<option value="professionista" <?php selected( $directory, 'professionista' ) ?>>Professionisti</option>
		</select>
	</div>
	<div class="ui-widget" style="margin-top:2em; font-family:Arial">
		Put the external ID here:
		<input type="text" id="guida-item-external-id-post" name="guida-item-external-id-post" value="<?php echo $extrn_id; ?>" style="width: 100%;"/>
	</div>
	<div class="ui-widget" style="margin-top:2em; font-family:Arial">
	  	Result:
	  	<div id="log" style="height: 200px; width: 100%; overflow: auto;" class="ui-widget-content"></div>
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

    if ( ! empty( $_POST['guida-item-external-id-post'] ) ) {
        update_post_meta( $post_id, 'guida-items-external-id', $_POST['guida-item-external-id-post'] );
    } else {
        delete_post_meta( $post_id, 'guida-items-external-id' );
    }
}
add_action('save_post', 'guida_items_directory_save_data');
?>