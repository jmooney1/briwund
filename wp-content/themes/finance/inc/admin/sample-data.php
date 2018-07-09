<?php
/**
 * Sample data installer class
 */
class themesflat_SampleData {
	private static $instance;

	private $data_tables = array();
	private $truncated_tables = array();
	private $table_prefix;

	/**
	 * Create instance for sample data installer
	 * 
	 * @return  void
	 */
	public static function init() {
		if ( self::$instance == null ) {
			self::$instance = new self();
		}
	}

	/**
	 * [__construct description]
	 */
	private function __construct() {
		if ( ! is_admin() )
			return;
		
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
		add_action( 'wp_ajax_sample_data', array( $this, 'invoke' ) );
		add_action('init',array($this,'start_section'));
	}

	function start_section() {
		session_start();
	}

	/**
	 * [admin_menu description]
	 * @return [type] [description]
	 */
	public function admin_menu() {
		add_theme_page( esc_html__( 'Sample Data Installation', 'finance' ),
						esc_html__( 'Sample Data', 'finance' ),
						'edit_theme_options', 'sample-data', array( $this, 'admin_page' ) );
	}

	/**
	 * [admin_page description]
	 * @return [type] [description]
	 */
	public function admin_page() {
		?>

		<div id="sample-data-installer">
			<h1><?php esc_html_e( 'Sample Data Installation', 'finance' ) ?></h1>

			<div class="start-screen">
				<p><?php esc_html_e( 'There is following tasks will be run for install sample data:', 'finance' ) ?></p>
				<ol class="tasks">
					<li><?php esc_html_e( 'Import sample content ', 'finance' ) ?>
						<progress style="display:none;" value="0" max="100"></progress>
						<div id="loading-center-absolute" class="loader hide_load">
							<div class="object" id="object_one"></div>
							<div class="object" id="object_two" style="left:20px;"></div>
							<div class="object" id="object_three" style="left:40px;"></div>
							<div class="object" id="object_four" style="left:60px;"></div>
							<div class="object" id="object_five" style="left:80px;"></div>
						</div>
						</li>
					<li><?php esc_html_e( 'Download media files', 'finance' ) ?> <span class="media-status"></span>
						<progress style="display:none;" value="0" max="100"></progress>
						<div id="loading-center-absolute" class="loader hide_load">
							<div class="object" id="object_one"></div>
							<div class="object" id="object_two" style="left:20px;"></div>
							<div class="object" id="object_three" style="left:40px;"></div>
							<div class="object" id="object_four" style="left:60px;"></div>
							<div class="object" id="object_five" style="left:80px;"></div>
						</div></li>
				</ol>
				<p class="finish-actions" style="display: none;">
					<span><?php esc_html_e( 'Congratulation! Sample data has been installed successfully', 'finance' ) ?></span><br>
					<a href="<?php echo esc_url( site_url() );?>"><?php esc_html_e('View Website','finance') ?></a>
				</p>

				<p>
					<button type="button" id="install-sample-data" class="button-primary"><?php esc_html_e( 'Install Sample Data', 'finance' ) ?></button>
				</p>
		</div>
			
	<?php 	
	}

	function update_max($val){
		$a = get_option('themesflat_max');
		$_max = ($a == '' ? $val : $a + $val);
		update_option('themesflat_max',$_max);
	}

	function preload($action_index=0) {
		global $wpdb;
		$a = get_option('themesflat_max');
		$_max = ($a == '' ? 0 : $a );
		$_action_index = get_option('action_index');
		$action_index = ( $_action_index == ''? 0: $_action_index);
		$actions = array('general','content','options','others');
		switch ($actions[$action_index]) {
			case 'content':
				$file_dir = THEMESFLAT_DIR."sampledata/content.json";
				$file_url = THEMESFLAT_LINK."sampledata/content.json";
				break;
			case 'options':
				$file_dir = THEMESFLAT_DIR."sampledata/options.json";
				$file_url = THEMESFLAT_LINK."sampledata/options.json";
				break;
			case 'others':
				$file_dir = THEMESFLAT_DIR."sampledata/others.json";
				$file_url = THEMESFLAT_LINK."sampledata/others.json";
				break;
			default:
				$file_dir = THEMESFLAT_DIR."sampledata/general.json";
				$file_url = THEMESFLAT_LINK."sampledata/general.json";
				break;
		}

		// importok
		if (file_exists($file_dir)) {
		$url = wp_remote_get($file_url);
		$themesflatgetdata = json_decode($url['body'],true);
	
		foreach ($themesflatgetdata as $key => $data) {
			 $table_name = $wpdb->prefix.$key;
			 $bypass = array ("{$wpdb->prefix}users","{$wpdb->prefix}usermeta","{$wpdb->prefix}user_roles");
			 $structure = $data['structure'];
			 $__data = $data['data'];
		 	 $_max = $_max + count($__data);

		     //table not in database. Create new table
		    $charset_collate = $wpdb->get_charset_collate();
			$sql = str_replace( "'","",$wpdb->prepare("CREATE TABLE IF NOT EXISTS  %s ( ",$table_name) );

			foreach ($structure as $_structure) {
			 	if($_structure['Key'] == "PRI") {
			 		$primary = str_replace( "'","",$wpdb->prepare("UNIQUE KEY (`%s`)",$_structure['Field']));
			 	}
			 	$null = ($_structure['Null'] == "NO" ? 'NOT NULL' : '');
			 	$sql .= "`{$_structure['Field']}` {$_structure['Type']} $null {$_structure['Extra']},";
			 }
			 $sql .= "$primary ) $charset_collate;";
			 $wpdb->query($sql);
				if ( !in_array($table_name, $bypass) && $key !=='options' ) :
					$wpdb->query( str_replace( "'","",$wpdb->prepare("TRUNCATE TABLE %s",$table_name) ));
				endif; 
			// }
			
		}// foreach
		update_option('themesflat_import_index',0);
		update_option('flat_import_keyindex',0);
		update_option('themesflat_max',$_max);
		$action_index = $action_index + 1;
		update_option('action_index',$action_index);
		if ($action_index < count($actions)) {
			return 'preload';
		}
		else {
			return 'import_small_data';
		}
	}
	else {
		return 'file not found';
	}
		//.import ok
}

function import_small_data() {
	global $wpdb;
	$file_name = THEMESFLAT_LINK."sampledata/general.json";
	$tmp = get_option('themesflat_tmp');
	$count = get_option('themesflat_small_count');
	if ( $count == '' ) {
		$count = 0;
	}
	$url = wp_remote_get($file_name);
	$_data = json_decode($url['body'],true);
	$allKeys = array_keys($_data);
	$value = get_option('themesflat_small_value');
	$key = array_search($value,$allKeys);
	if ($value == '' ) {
		$key = 0;
	}
	$array_action = array_slice($allKeys, $key);
	foreach ($array_action as $value) {
		$table_name = $wpdb->prefix.$value;
		$row = $_data[$value];
		$__data= $row['data'];
		$_key = get_option('themesflat_small_index');
		if ($_key == '') {
			$_key =0;
		}
		$_to = $_key +500 ;
		if (count($__data) < $_to + 1) {
			$_to = count($__data);
		}
		update_option('themesflat_small_value',$value);
		for ( $i=$_key;$i<$_to;$i++ ) {
			update_option('themesflat_small_index',$i);
		   	$wpdb->replace($table_name,$__data[$i]);
	    }
	   update_option('themesflat_small_index',0);
	   $count += $_to;
	   update_option('themesflat_small_count',$count);
	}
	
	$count = $tmp + $count;
	return $count;
}

	function multi_import() {
		global $wpdb;
		$tmp = get_option('themesflat_tmp');
		$data_key = array('content','others','options');
		$datakey_index = get_option('themesflat_import_datakey_index');
		$index = get_option('themesflat_import_index');
		$key = $data_key[$datakey_index];
		$file_name = THEMESFLAT_LINK.sprintf("sampledata/%s.json",$key);
		$url = wp_remote_get($file_name);
		$themesflatgetdata = json_decode($url['body'],true);
		foreach ($themesflatgetdata as $key => $data) {
			$_data = $data['data'];
		}
		$table_name = $wpdb->prefix.$key;
		$bypass = array ("{$wpdb->prefix}users","{$wpdb->prefix}usermeta");
		$bypass_options = array("blogname","blogdescription","admin_email","{$wpdb->prefix}user_roles","capabilities","active_plugins");
		$_to = $index + 500;
	
		if (count($_data) > $_to) {
			update_option('themesflat_import_index',$_to );
		}
		else {
			$_to = count($_data);
			$datakey_index = $datakey_index + 1;
			update_option('themesflat_import_index',0);
			update_option('themesflat_import_datakey_index',$datakey_index);
			$tmp +=  $_to;
			update_option('themesflat_tmp',$tmp);
		
		}

		if ( !in_array($table_name, $bypass) && !empty($_data) ) :
			for ( $i = $index;$i < $_to;$i++ ) {
				if ( $key == 'options' && $_data[$i]['option_name'] == 'siteurl'){
					$base_url = $_data[$i]['option_value'];
				}
				elseif (!in_array($_data[$i]['option_name'],$bypass_options)) {
					$wpdb->replace($table_name,$_data[$i]);
				}
			}
		endif;

		if ($datakey_index == count($data_key)) {
			return 'update_data';
		}
		return $_to + $tmp;
	}

	function update_data(){
		global $wpdb;
		/**
		 * Update the author
		 */
		$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->posts} SET post_author=%d", get_current_user_id() ) );

		/**
		 * Update link in the post content
		 */
		$base_url = get_option('themesflat_base_url');
		$current_url = get_site_url();

		$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->posts} SET guid=REPLACE(guid, %s, %s) WHERE post_type NOT IN( 'attachment' )",
			trailingslashit( $base_url),
			trailingslashit( $current_url )
		) );

	}

	/**
	 * Enqueue script for sample data installation page
	 * 
	 * @return  void
	 */
	public function enqueue( $page ) {
		if ( $page == 'appearance_page_sample-data' ) {
			wp_enqueue_style( 'themesflat-sample-data',THEMESFLAT_LINK . 'css/admin/sample.css' );
			wp_enqueue_script( 'themesflat-sample-data', THEMESFLAT_LINK . 'js/admin/sample-data.js', array(),'1.0', true );	

			wp_localize_script( 'themesflat-sample-data', '_sampleDataLocalization', array(
				'confirm_installation' => esc_html__( 'Attention!!! Your existing data will be removed when install sample data. Are you sure you want to install sample data?', 'finance' )
			) );

			wp_localize_script( 'themesflat-sample-data', '_sampleDataInfo', array(
				'siteURL' => site_url(),
				'nonce'   => wp_create_nonce( 'sample_data_installation' )
			) );
		}
	}

	function themesflat_reset() {
		update_option('themesflat_attachment_ids',0);
		update_option('attachment_ids_index',0);
		update_option('themesflat_import_index',0);
		update_option('themesflat_import_datakey_index',0);
		update_option('themesflat_max',0);
		update_option('action_index',0);
		update_option('themesflat_tmp',0);
		delete_option('themesflat_small_value');
		delete_option('themesflat_small_index');
		update_option('themesflat_small_count',0);
		return 'preload';
	}

	/**
	 * [invoke description]
	 * @return [type] [description]
	 */
	public function invoke() {
		if(isset( $_POST['step'])):
		switch ($_POST['step']) {
			case 'reset':
				 $response['step'] = $this->themesflat_reset();
				 break;
			case 'preload':
				$response['step'] =  $this->preload();
				break;
			case 'import_small_data':
				$response['max'] = get_option("themesflat_max");
				$response['current'] = $this->import_small_data();
				$response['step'] = 'import_content';
				break;
			case 'import_content':
				$import_content = $this->multi_import();
				if ( $import_content == 'update_data') {
					$response['step'] = 'update_data';
				}
				else {
					$response['max'] = get_option("themesflat_max");
					$response['step'] = 'import_content';
					$response['current'] = $import_content;
				}
				break;
			
			case 'update_data':
				$this->update_data();
				$response['step'] = 'get_ids';
				break;
			case 'get_ids':
				/**
				 * Fetch the attachment Ids
				 */
				$attachment_ids = array();
				$attachment_query = new WP_Query( array(
						'post_type'   => 'attachment',
						'post_status' => 'any',
						'nopaging'    => true
					) );
				while ( $attachment_query->have_posts() ) {
					$attachment_query->next_post();
					$attachment_ids[] = $attachment_query->post->ID;
				}
				update_option('themesflat_attachment_ids',$attachment_ids);
				update_option('attachment_ids_index',0);
				$response['step'] = 'download-attachment';
				$response['media_index'] = get_option('attachment_ids_index');
				$response['media_ids'] = count(get_option('themesflat_attachment_ids'));
				break;
			case 'download-attachment':
				$response['step'] = $this->download_attachment();
				$response['media_index'] = get_option('attachment_ids_index');
				$response['media_ids'] = count(get_option('themesflat_attachment_ids'));
				break;

		}
		endif;
		wp_send_json($response);		
	}

	/**
	 * [download_attachment description]
	 * @param  [type] $response [description]
	 * @param  [type] $context  [description]
	 * @return [type]           [description]
	 */
	public function download_attachment() {
		global $wp_filesystem, $wpdb;
			$attachment_ids = get_option('themesflat_attachment_ids');
			$attachment_ids_index = get_option('attachment_ids_index');
			$attachment_id = $attachment_ids[$attachment_ids_index];
			if ( isset( $attachment_id ) ) {
				@set_time_limit( 90 );

				// Initialize FileSystem API
				WP_FileSystem();

				$attachment = get_post( $attachment_id );
				$upload_dir = wp_upload_dir();
				
				$attached_file    = end( explode( '/uploads', $attachment->guid ) );
				$destination_path = $upload_dir['basedir'];

				foreach ( explode( '/', dirname( $attached_file ) ) as $part ) {
					$destination_path = trailingslashit( $destination_path ) . $part;
					wp_mkdir_p( $destination_path );
				}

				update_post_meta( $attachment->ID, '_wp_attached_file', trim( $attached_file, '/' ) );

				$destination = trailingslashit( $destination_path ) . basename( $attached_file );
				$remote_response = wp_safe_remote_get( $attachment->guid, array(
					'timeout' => 90, 'stream' => true, 'filename' => $destination ) );

				$response_code = wp_remote_retrieve_response_code( $remote_response );

				if ( ($response_code != 200) && ($response_code != 404) && ($response_code != 504)) {
					if ( is_wp_error( $response_code ) )
						throw new Exception( $response_code->get_error_message() );

					throw new Exception( $remote_response, $response_code );
				}

				$wpdb->update( $wpdb->posts,
					array( 'guid' => $upload_dir['baseurl'] . $attached_file ),
					array( 'ID'   => $attachment->ID )
				);

				$attach_data = wp_generate_attachment_metadata( $attachment->ID, $destination );
				wp_update_attachment_metadata( $attachment->ID, $attach_data );
			}
			$attachment_ids_index += 1;

			if ($attachment_ids_index < count($attachment_ids)) {
				update_option('attachment_ids_index',$attachment_ids_index);
				return 'download-attachment';
			}
			else {
				return 'complete';
			}
		}

	}


themesflat_SampleData::init();
