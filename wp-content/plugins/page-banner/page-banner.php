<?php

/*
Plugin Name: Page Banners
Plugin URI: sig-ad.com
Description: Adds a basic banner with area for a heading 1 and heading 2. Easy to style.
Author: Phillip Werner
Author URI:
License: GPLv2
*/

add_action('wp_enqueue_scripts', 'page_banner_stylesheet');

function page_banner_stylesheet(){
	wp_enqueue_style('privatepagestylesheet', plugins_url('page-banner-styles.css', __FILE__));
}

add_action( 'post_edit_form_tag', 'ch5_cfu_form_add_enctype' );

function ch5_cfu_form_add_enctype() {
	echo ' enctype="multipart/form-data"';
}

add_action( 'add_meta_boxes', 'ch5_cfu_register_meta_box' );
add_action('admin_enqueue_scripts', 'load_wp_media_files');

function load_wp_media_files($page){
	if($page == 'post.php'){
		wp_enqueue_media();
		wp_enqueue_script('myprefix_script', plugins_url('/js/myscript.js', __FILE__), array('jquery'), '0.1');
	}
}
// Ajax action to refresh the user image
add_action( 'wp_ajax_myprefix_get_image', 'myprefix_get_image'   );
function myprefix_get_image() {
    if(isset($_GET['id']) ){
        $image = wp_get_attachment_image( filter_input( INPUT_GET, 'id', FILTER_VALIDATE_INT ), 'medium', false, array( 'id' => 'myprefix-preview-image' ) );
        $data = array(
            'image'    => $image,
        );
        wp_send_json_success( $data );
    } else {
        wp_send_json_error();
    }
}

//Meta boxes for posts and pages
function ch5_cfu_register_meta_box() {
	add_meta_box( 'ch5_cfu_upload_file', 'Upload Banner',
		'ch5_cfu_upload_meta_box', 'post', 'normal' );
	add_meta_box( 'ch5_cfu_upload_file', 'Upload Banner',
		'ch5_cfu_upload_meta_box', 'page', 'normal' );
}

//HTML for Upload Banner
function ch5_cfu_upload_meta_box( $post ) {
	$post_source_header1 =
esc_html( get_post_meta( $post->ID, 'post_source_header1',
true ) );
$post_source_header2 =
esc_html( get_post_meta( $post->ID,
'post_source_header2',
true ) );
?>
<table>
	<tr>
		<td style="width: 150px">Banner Image</td>
		<td>
			<?php
		// Retrieve attachment data for post
			$attachment_data = get_post_meta( $post->ID,
				'attach_data',
				true );
		// Display post link if data is present
			// if ( empty ( $attachment_data ) ) {
			// 	echo 'No Attachment Present';
			// } else {
			// 	echo '<img class="back_image" width="300px" height="auto" src="';
			// 	echo esc_url( $attachment_data['url'] );
			// 	echo '"/>';
			// }
			?>
		</td>
	</tr>

	<tr>
		<td><?php $image_id = get_post_meta(get_the_ID(), 'upload_pdf');

if( intval( $image_id ) > 0 ) {
	$image_id = $image_id[0];
    // Change with the image size you want to use
    $image = wp_get_attachment_image( $image_id, 'medium', false, array( 'id' => 'myprefix-preview-image' ) );
} else {
    // Some default image
    $image = '<img id="myprefix-preview-image" src="https://some.default.image.jpg" />';
}
?>
 <?php echo $image; ?>
 <input type="hidden" name="upload_pdf" id="myprefix_image_id" value="<?php echo esc_attr( $image_id ); ?>" class="regular-text" />
 <input type='button' class="button-primary" value="<?php esc_attr_e( 'Select a image', 'mytextdomain' ); ?>" id="myprefix_media_manager"/></td>
	</tr>
	<tr>
		<td>Header 1</td>
		<td>
			<input type="text" size="40" name="post_source_header1" value="<?php echo $post_source_header1; ?>" />
		</td>
	</tr>
	<tr>
		<td>Header 2</td>
		<td>
			<input type="text" size="40" name="post_source_header2" value="<?php echo $post_source_header2; ?>" />
		</td>
	</tr>
	<tr>
		<td>Delete Banner:</td>
		<td><input type="submit" name="delete_attachment"
			class="button-warning"
			id="delete_attachment" style="background-color: red; color: white; padding: 5px; border-radius: 5px; cursor: pointer"
			value="Delete Banner" /></td>
		</tr>
	</table>
	<?php }


	//add action for the uploading of the actual file
	add_action( 'save_post', 'save_uploaded_file', 10, 2 );

//Handle the saving of the uploaded file
	function save_uploaded_file( $post_id = false,
		$post = false ) {
		if ( 'post' == $post->post_type ||
			'page' == $post->post_type ) {
// Store data in post meta table if present in post data
			if ( isset( $_POST['post_source_header1'] ) ) {
				update_post_meta( $post_id, 'post_source_header1',
					sanitize_text_field(
						$_POST['post_source_header1'] ) );
			}
			if ( isset( $_POST['post_source_header2'] ) ) {
				update_post_meta( $post_id, 'post_source_header2',
					sanitize_text_field(
						$_POST['post_source_header2'] ) );			}
		}
			if( isset($_POST['upload_pdf'])){
				update_post_meta($post_id, 'upload_pdf', $_POST['upload_pdf']);
			}
		//Set the if statement to see if there is media uploaded
		if ( isset($_POST['delete_attachment'] ) ) {
			$attach_data = get_post_meta( $post_id, 'upload_pdf',
				true );
			if ( !empty( $attach_data ) ) {
				unlink( $attach_data['upload_pdf'] );
				delete_post_meta( $post_id, 'upload_pdf');
			}
		} elseif ( 'post' == $post->post_type ||
			'page' == $post->post_type ) {
// Look to see if file has been uploaded by user
			// if( array_key_exists( 'upload_pdf', $_FILES ) &&
			// 	!$_FILES['upload_pdf']['error'] ) {
// Retrieve file type and store lower-case version


// Display error message if file is not a png or jpg
// Send uploaded file data to upload directory
				// $upload_return = wp_upload_bits(
				// 	$_FILES['upload_pdf']['name'], null,
				// 	file_get_contents(
				// 		$_FILES['upload_pdf']['tmp_name'] ) );
// Replace backslashes with slashes for Windows
// web servers
				// $upload_return['file'] =
				// str_replace( '\\', '/',
				// 	$upload_return['file'] );
// Set upload path data if successful.
			// 	if ( isset( $upload_return['error'] ) &&
			// 		$upload_return['error'] != 0 ) {
			// 		$errormsg = 'There was an error uploading';
			// 	$errormsg .= 'your file. The error is: ';
			// 	$errormsg .= $upload_return['error'];
			// 	wp_die( $errormsg );
			// 	exit;
			// } else {
				$attach_data = get_post_meta( $post_id,
					'attach_data',[ 203 ], true );
				// if ( !empty( $attach_data ) ) {

				// }
				// update_post_meta( $post_id, 'attach_data',
				// 	$upload_return );
			// }
		}


}

add_shortcode('page-banner', 'displayBanner');

function displayBanner () {
	$post_id = get_the_ID();
	$image = '';
	if ( !empty( $post_id ) ) {
		if ( 'post' == get_post_type( $post_id ) ||
			'page' == get_post_type( $post_id ) ) {
			$attachment_data = get_post_meta( $post_id, 'upload_pdf', true );
		$post_source_header1 = get_post_meta($post_id, 'post_source_header1', true);
		$post_source_header2 = get_post_meta($post_id, 'post_source_header2', true);
		if ( !empty( $attachment_data ) ) {
			if($post_source_header2){
			$image = '<div class="file_attachment"><img id="cover-image" src="/wp-content/uploads/2018/06/cover.png" /><div class="cover-page"><div class="header_1"> '.$post_source_header1 . '</div>';
			$image .= '<div class="header_2"> '.$post_source_header2 . '</div>';
		}
		else if($post_source_header1){
			if(strlen($post_source_header1) > 20){ 
				$image = '<div class="file_attachment"><img id="cover-image" src="/wp-content/uploads/2018/06/cover.png" /><div class="cover-page"><div class="header_1_lone_large"> '.$post_source_header1 . '</div>';
			}
			else{ 
			$image = '<div class="file_attachment"><img id="cover-image" src="/wp-content/uploads/2018/06/cover.png" /><div class="cover-page"><div class="header_1_lone"> '.$post_source_header1 . '</div>';
		}
		}
		$attachment_data = wp_get_attachment_image_src( $attachment_data, 'full', false, array( 'id' => 'myprefix-preview-image' ) );
		$attachemnt_data;
			$image .= '</div><img src="';
			$image .= esc_url( $attachment_data[0]);
			$image .= '" width="100%" />' ;
			$image .= '</div></div>';
			$image .= '<?php echo torque_breadcrumbs() ?>';

		}
	}
}
return $image;
}


