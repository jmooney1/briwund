<?php
/**
 * Sample data installer class
 */

class themesflat_exportData
{
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
	}

	/**
	 * [admin_menu description]
	 * @return [type] [description]
	 */
	public function admin_menu() {
		add_theme_page( esc_html__( 'export Data Installation', 'finance' ),
						esc_html__( 'Sample Data', 'finance' ),
						'edit_theme_options', 'export-data', array( $this, 'admin_page' ) );
	}

	/**
	 * [admin_page description]
	 * @return [type] [description]
	 */
	public function admin_page() {
		?>
	<?php global $wpdb;
	//create ok
	 update_option('flat_base_url',get_site_url());
	 $bypass_option = array("'home'","'blogname'","'blogdescription'","'admin_email'","'{$wpdb->prefix}user_roles'","'active_plugins'","'capabilities'","'users'","'usermeta'");
	 $bypass_text = implode($bypass_option,",");
	foreach ( $wpdb->get_results( "SHOW TABLES", ARRAY_N ) as $table ) {

		$abc = $wpdb->get_results( str_replace( "'","",$wpdb->prepare("DESCRIBE %s;",$table[0]) ),ARRAY_A);
		$table_name = str_replace($wpdb->prefix, '', $table[0]);
		$user_roles = "{$wpdb->prefix}user_roles";
		$sql = '';
		if ($table_name == 'options' ) {
			 // $sql =  $wpdb->prepare("
				// SELECT * 
				// FROM `$table[0]` 
				// WHERE option_name NOT IN ($bypass_text)");
			 $sql = "
				SELECT * 
				FROM `$table[0]` 
				WHERE option_name NOT IN (".$bypass_text.")";
		}

		elseif ($table_name != 'usermeta' && $table_name != 'users') {
			$sql = $wpdb->prepare("
				SELECT * 
				FROM %s",$table[0]);
			$sql = str_replace( "'","",$sql );
		}
		if ($sql != '') {
			$te = $wpdb->get_results( $sql, ARRAY_A ); 

		 	switch ($table_name) {
				case 'options':
					$options[$table_name]['structure'] = $abc;
					$options[$table_name]['data'] = $te;
					break;

				case 'postmeta':
					$postmeta[$table_name]['structure'] = $abc;
					$postmeta[$table_name]['data'] = $te;
					break;

				case 'posts':
					$posts[$table_name]['structure'] = $abc;
					$posts[$table_name]['data'] = $te;
					break;

				default:
					$flatdata[$table_name]['structure'] = $abc;
					$flatdata[$table_name]['data'] = $te;
					break;
			}
		}
	}

	global $wp_filesystem;
	// Initialize the WP filesystem, no more using 'file-put-contents' function
	if (empty($wp_filesystem)) {
	  themesflat_wpfilesystem();
	}
	$wp_filesystem->put_contents(THEMESFLAT_DIR."sampledata/general.json",json_encode($flatdata));
	$wp_filesystem->put_contents(THEMESFLAT_DIR."sampledata/others.json",json_encode($postmeta));
	$wp_filesystem->put_contents(THEMESFLAT_DIR."sampledata/options.json",json_encode($options));
	$wp_filesystem->put_contents(THEMESFLAT_DIR."sampledata/content.json",json_encode($posts));
	echo 'export data complete';
//.createok
}
}

/**
 * Initialize sample data installer
 */
themesflat_exportData::init();



