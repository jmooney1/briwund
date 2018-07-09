<?php
/*
Plugin Name: Homepage-Banner
Plugin URI: sig-ad.com
Description: Adds a basic homepage banner with area for text.
Author: Phillip Werner
Author URI:
License: GPLv2
*/
 require_once(ABSPATH . "wp-admin" . '/includes/image.php');
 require_once(ABSPATH . "wp-admin" . '/includes/file.php');
 require_once(ABSPATH . "wp-admin" . '/includes/media.php');

/* CREATING THE NEW DATABASE TABLE */

register_activation_hook( __FILE__, 'ch8bt_activation' );

wp_enqueue_script("jquery");

add_action('admin_enqueue_scripts', 'load_media_files');

function load_media_files(){

		wp_enqueue_media();
		wp_enqueue_script('myprefix_script', plugins_url('/js/myscript.js', __FILE__), array('jquery'), '0.1');

}

add_action('wp_enqueue_scripts', 'homepage_banner_stylesheet');

function homepage_banner_stylesheet(){
	wp_enqueue_style('privatestylesheet', plugins_url('home-banner-stylesheet.css', __FILE__));

	wp_enqueue_script('newscript', plugins_url('scripts.js', __FILE__));

}



function ch8bt_activation() {
// Get access to global database access class
	global $wpdb;
// Check to see if WordPress installation is a network
	if ( is_multisite() ) {
// If it is, cycle through all blogs, switch to them
// and call function to create plugin table
		if ( !empty( $_GET['networkwide'] ) ) {
			$start_blog = $wpdb->blogid;
			$blog_list =
			$wpdb->get_col( 'SELECT blog_id FROM ' . $wpdb->blogs );
			foreach ( $blog_list as $blog ) {
				switch_to_blog( $blog );
// Send blog table prefix to creation function
				ch8bt_create_table( $wpdb->get_blog_prefix() );
			}
			switch_to_blog( $start_blog );
			return;
		}
	}
// Create table on main blog in network mode or single blog
	ch8bt_create_table( $wpdb->get_blog_prefix() );

// Register function to be called when new blogs are added
// to a network site
	add_action( 'wpmu_new_blog', 'ch8bt_new_network_site' );
function ch8bt_new_network_site( $blog_id ) {
		global $wpdb;
// Check if this plugin is active when new blog is created
// Include plugin functions if it is
		if ( !function_exists( 'is_plugin_active_for_network' ) ) {
			require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
		}
// Select current blog, create new table and switch back
		if ( is_plugin_active_for_network( plugin_basename( __FILE__ ) ) ) {
			$start_blog = $wpdb->blogid;
			switch_to_blog( $blog_id );
// Send blog table prefix to table creation function
			ch8bt_create_table( $wpdb->get_blog_prefix() );
			switch_to_blog( $start_blog );
		}
	}
}


function ch8bt_create_table( $prefix ) {
// Prepare SQL query to create database table
// using function parameter
	$creation_query = 'CREATE TABLE IF NOT EXISTS ' .
	$prefix . 'homepage_banners (
		`banner_id` int(20) NOT NULL AUTO_INCREMENT,
		`banner_image` text,
		`banner_header_1` text,
		`banner_header_2` text,
		`button_link` text,
		`banner_order` int(3) NOT NULL DEFAULT 0,
		`banner_creation_date` date DEFAULT NULL,
		PRIMARY KEY (`banner_id`)
	);';
	global $wpdb;
	$wpdb->query( $creation_query );
}












add_action( 'admin_menu', 'ch8bt_settings_menu' );


function ch8bt_settings_menu() {
	add_options_page( 'Homepage Banners',
		'Homepage Banner',
		'manage_options', 'homepage-banners',
		'ch8bt_config_page' );
}


add_action( 'admin_init', 'ch8bt_admin_init' );


function ch8bt_admin_init() {
	add_action( 'admin_post_save_ch8bt_bug', 'process_ch8bt_bug' );
}


function process_ch8bt_bug() {
	if ( !current_user_can( 'manage_options' ) ) {
		wp_die( 'Not allowed' );
	}
// Check if nonce field is present for security
	check_admin_referer( 'homepage-banners_add_edit' );
	if($_POST['status'] == "delete"){
global $wpdb;

$query = 'Delete from ' .$wpdb->get_blog_prefix();
$query .= 'homepage_banners WHERE banner_id = %d';
$wpdb->query($wpdb->prepare($query, intval($_POST['banner_id'])));
wp_redirect( add_query_arg( 'page', 'homepage-banners',
		admin_url( 'options-general.php' ) ) );
	exit;
}
else{
	global $wpdb;
	// $upload_overrides = array( 'test_form' => false );
	// $movefile = wp_handle_upload(file_get_contents($_FILES["banner_image"]["name"]), $upload_overrides);
	// $upload_return = wp_upload_bits(
	// 				$_FILES['banner_image']['name'], null,
	// 				file_get_contents(
	// 					$_FILES['banner_image']['tmp_name'] ) );
// Place all user submitted values in an array (or empty
// strings if no value was sent)
	// $new = wp_upload_bits($_FILES["banner_image"]["name"], null, file_get_contents($_FILES["banner_image"]["tmp_name"]));
	// $arr_file_type = wp_check_filetype(basename($_FILES["banner_image"]["name"]));
	// $uploaded_file_type = $arr_file_type['type'];
	 // Set an array containing a list of acceptable formats
                   //  $allowed_file_types = array('image/jpg','image/jpeg','image/gif','image/png');
                   // print_r($upload_return['url']);


	$bug_data = array();

	$bug_data['banner_image'] = $_POST['upload_pdf'];
	$bug_data['banner_header_1'] =
	( isset( $_POST['banner_header_1'] ) ?
		$_POST['banner_header_1'] : '' );
	$bug_data['banner_header_2'] =
	( isset( $_POST['banner_header_2'] ) ?
		sanitize_text_field( $_POST['banner_header_2'] ) : '' );
	$bug_data['button_link'] = ( isset( $_POST['button_link'] ) ?
		sanitize_text_field( $_POST['button_link'] ) : '' );
	$bug_data['banner_order'] = ( isset( $_POST['banner_order'] ) ?
		sanitize_text_field( $_POST['banner_order'] ) : '' );
// Call the wpdb insert or update method based on value
// of hidden bug_id field
	if ( isset( $_POST['banner_id'] ) && 0 == $_POST['banner_id'] ) {
		$wpdb->insert( $wpdb->get_blog_prefix() . 'homepage_banners',
			$bug_data );
	} elseif ( isset( $_POST['banner_id'] ) &&
		$_POST['banner_id'] > 0 ) {
		$wpdb->update( $wpdb->get_blog_prefix() . 'homepage_banners',
			$bug_data,
			array( 'banner_id' => intval( $_POST['banner_id'] ) ) );
	}
//Redirect the page to the user submission form
	wp_redirect( add_query_arg( 'page', 'homepage-banners',
		admin_url( 'options-general.php' ) ) );
	exit;
}
}


function ch8bt_config_page() {
	global $wpdb;
	?>
	<!-- Top-level menu -->
	<div id="ch8bt-general" class="wrap">
		<h2>Homepage Banner <a class="add-new-h2" href="<?php echo
		add_query_arg( array( 'page' => 'homepage-banners',
			'id' => 'new' ),
			admin_url('options-general.php') ); ?>">
		Add New Banner</a></h2>
		<!-- Display bug list if no parameter sent in URL -->
		<?php if ( empty( $_GET['id'] ) ) {
			$bug_query = 'select * from ' . $wpdb->get_blog_prefix();
			$bug_query .= 'homepage_banners ORDER by banner_order ASC';
			$bug_items = $wpdb->get_results( $bug_query, ARRAY_A );
			?>
			<h3>Manage Banners</h3>
			<table class="wp-list-table widefat fixed">
				<thead><tr><th style="width: 80px">ID</th>
					<th style="width: 300px">Image</th>
					<th style="width: 300px">Header 1</th>
					<th style="width: 300px">Button</th>
					<th>Link</th>
					<th>Order</th></tr></thead>
					<?php
// Display bugs if query returned results
					if ( $bug_items ) {
						foreach ( $bug_items as $bug_item ) {
							print_r($img = wp_get_attachment_image_src( $bug_item['banner_image'], 'medium' ));
							echo '<tr style="background: #FFF">';
							echo '<td>' . $bug_item['banner_id'] . '</td>';
							echo '<td><a href="';
							echo add_query_arg( array(
								'page' => 'homepage-banners',
								'id' => $bug_item['banner_id'] ),
							admin_url( 'options-general.php' ) );

							echo '"><img src=' . esc_url($img[0]) . ' width="200px" height="auto" /></a></td>';
							echo '<td>' . stripslashes($bug_item['banner_header_1']) . '</td>';
							echo '<td>' . $bug_item['banner_header_2'] . '</td>';
							echo '<td>' . $bug_item['button_link'] . '</td>';
							echo '<td>' . $bug_item['banner_order'];
							echo '</td></tr>';

						}
					} else {
						echo '<tr style="background: #FFF">';
						echo '<td colspan="3">No Banners Found</td></tr>';
					}
					?>

				</table><br />
				<?php } elseif ( isset( $_GET['id'] ) &&
					( 'new' == $_GET['id'] ||
						is_numeric( $_GET['id'] ) ) ) {
					$bug_id = intval( $_GET['id'] );
					$mode = 'new';
// Query database if numeric id is present
					if ( $bug_id > 0 ) {
						$bug_query = 'select * from ' . $wpdb->get_blog_prefix();
						$bug_query .= 'homepage_banners where banner_id = %d';
						$bug_data =
						$wpdb->get_row( $wpdb->prepare( $bug_query, $bug_id ),
							ARRAY_A );
// Set variable to indicate page mode
						if ( $bug_data ) {
							$mode = 'edit';
						}
					}
					if ( 'new' == $mode ) {
						$bug_data = array(
							'banner_image' => '', 'banner_header_1' => '',
							'banner_header_2' => '', 'banner_order' => ''
						);
					}
// Display title based on current mode
					if ( 'new' == $mode ) {
						echo '<h3>Add New Banner</h3>';
					} elseif ( 'edit' == $mode ) {
						echo '<h3>Edit Banner #' . $bug_data['banner_id'] . ' - ';
						echo $bug_data['banner_image'] . '</h3>';
					}
					?>
					<form method="post" action="<?php echo admin_url( 'admin-post.php' ); ?>"
						enctype="multipart/form-data">
						<input type="hidden" name="action" value="save_ch8bt_bug" />
						<input type="hidden" name="banner_id"
						value="<?php echo $bug_id; ?>" />
						<!-- Adding security through hidden referrer field -->
						<?php wp_nonce_field( 'homepage-banners_add_edit' ); ?>
						<!-- Display bug editing form -->
						<table>
							<tr>
								<td style="width: 150px">Image</td>
								<?php
								 $image_id = $bug_data['banner_image'];
								if( intval( $image_id ) > 0 ) {

    // Change with the image size you want to use
    $image = wp_get_attachment_image( $image_id, 'medium', false, array( 'id' => 'myprefix-preview-image' ) );
} else {
    // Some default image
    $image = '<img id="myprefix-preview-image" src="https://some.default.image.jpg" />';
} ?>
								<td><?php echo $image; ?>
 <input type="hidden" name="upload_pdf" id="myprefix_image_id" value="<?php echo esc_attr( $image_id ); ?>" class="regular-text" />
 <input type='button' class="button-primary" value="<?php esc_attr_e( 'Select a image', 'mytextdomain' ); ?>" id="myprefix_media_manager"/></td></td>
									</tr>
									<tr>
										<td>Header 1</td>
										<td><textarea name="banner_header_1"
											cols="60"><?php
											$banner_head_1 = stripslashes($bug_data['banner_header_1']);	
											 echo
											esc_textarea( $banner_head_1 ); ?></textarea></td>
										</tr>
										<tr>
										<td>Button</td>
										<td><textarea name="banner_header_2"
											cols="60"><?php echo
											esc_textarea( $bug_data['banner_header_2'] ); ?></textarea></td>
										</tr>
										<tr>
										<td>Button Link</td>
										<td><textarea name="button_link"
											cols="60"><?php echo
											esc_textarea( $bug_data['button_link'] ); ?></textarea></td>
										</tr>
										<tr>
											<td>Order</td>
											<td><input type="text" name="banner_order"
												value="<?php echo esc_html(
													$bug_data['banner_order'] ); ?>" /></td>
												</tr>
												<tr>
													<td>Status</td>
													<td>
														Active <input type="radio" name="status" value="active" checked/>
														Delete <input type="radio" name="status" value="delete"/>
													</td>
													<td>
														<!-- <select name="bug_status">
															 <?php
// Display drop-down list of bug statuses
// 															$bug_statuses = array( 0 => 'Open', 1 => 'Closed',
// 																2 => 'Not-a-Bug' );
// 															foreach( $bug_statuses as $status_id => $status ) {
// // Add selected tag when entry matches
// 																echo '<option value="' . $status_id . '" ';
// 																selected( $bug_data['bug_status'],
// 																	$status_id );
// 																echo '>' . $status;
// 															}?>
															<!--
														</select> -->
													</td>
												</tr>
											</table>
											<input type="submit" value="Submit" class="button-primary" />
										</form>
									</div>
									<?php }
								}




add_shortcode('home-banner', 'home_banner_shortcode');

function home_banner_shortcode($atts, $content = null){
	$count = 0;
	$output;
	global $wpdb;
	$bug_query = 'select * from ' . $wpdb->get_blog_prefix();
			$bug_query .= 'homepage_banners ORDER by banner_order ASC';
			$bug_items = $wpdb->get_results( $bug_query, ARRAY_A );
			$output = '<section class="demo">
  <button class="next">Next</button>
  <button class="prev">Previous</button>
<div class="homebanner">';
	foreach($bug_items as $items){
		$count++;
		if($count == 1){
			$output .= '<div class="banner" style="display:inline-block">';
		}
		else{
			$output .= '<div class="banner" style="display:none">';
		}
        $attachment_data = wp_get_attachment_image_src($items['banner_image'], 'full', false, array('id'=> 'myprefix-preview-image'));
		$output .= '<div class="homebanner-cover">';
		$output .= '<div class="home_header_1">'.stripslashes($items['banner_header_1']).'</div><p class="home_header_2">'.$items['banner_header_2'].'</p><a href="'.$items['button_link'].'"><span class="learn-more" style="color: #eb812d">Learn More <img src="/wp-content/uploads/2018/06/read-more.png" style="width: 12px"/></span></a></div>';
		$output .= '<img src="'.esc_url($attachment_data[0]).'" />';
		$output .= '</div>';

	}
		$output .= '</div></section>';

		return $output;
}
