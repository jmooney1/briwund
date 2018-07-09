<?php
class Themesflat_Flicker extends WP_Widget {
    /**
     * Holds widget settings defaults, populated in constructor.
     *
     * @var array
     */
    protected $defaults;

    /**
     * Constructor
     *
     * @return Themes_Flicker
     */
    function __construct() {
        $this->defaults = array(
            'title' 		=> 'Flickr widget',
			'flickrID'		=> '136845742@N02',
			'imgcount' 		=> '9',
			'type' 			=> 'user',
			'display'		=> 'latest',
			'auto'			=> 'true',
			'item_in_row' 	=> '3'			
        );

        parent::__construct(
            'widget_flicker',
            esc_html__( 'themesflat - flat Flicker', 'finance' ),
            array(
                'classname'   => 'widget_flicker',
                'description' => esc_html__( 'Displays your Flickr Photos.', 'finance' )
            )
        );
    }

    /**
     * Display widget
     */
    function widget( $args, $instance ) {

        $instance = wp_parse_args( $instance, $this->defaults );
        extract( $instance );

        extract( $args );

		if ( !$instance['flickrID'] )
			return;

		extract( $args );
		echo $before_widget;
		
		if ( $title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) )
			echo $before_title . $title . $after_title;
		?>

		<div class="flickr-photos clearfix" data-autoplay="<?php echo (bool)( $auto ); ?>" data-item-show="<?php echo intval( $item_in_row ); ?>">		
		<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo intval( $imgcount ); ?>&amp;display=<?php echo esc_attr( $display ); ?>&amp;size=s&amp;layout=x&amp;source=<?php echo esc_attr( $type ); ?>&amp;<?php echo esc_attr( $type ); ?>=<?php echo esc_attr( $flickrID ); ?>"></script>
		</div><!--/.flickr-photos -->		
		<?php 
		echo $after_widget;

    }

    /**
     * Update widget
     */
    function update( $new_instance, $old_instance ) {

        $instance               	= $old_instance;

        $instance['title'] 			= strip_tags( $new_instance['title'] );
		$instance['flickrID'] 		= strip_tags( $new_instance['flickrID'] );
		$instance['imgcount'] 		= intval( $new_instance['imgcount'] );
		$instance['type'] 			= strip_tags( $new_instance['type'] );
		$instance['display'] 		= strip_tags( $new_instance['display'] );
		$instance['auto']     		= isset( $new_instance['auto'] ) ? (bool) $new_instance['auto'] : false;		
		$instance['item_in_row'] 	= intval( $new_instance['item_in_row'] );
        
        return $instance;
    }

    /**
     * Widget setting
     */
    function form( $instance ) {

        $instance = wp_parse_args( $instance, $this->defaults );
        
		$auto = $instance['auto'] ? "checked" : "";
		$navigation	= isset( $instance['navigation'] ) ? (bool) $instance['navigation'] : false;	
		$auto	= isset( $instance['auto'] ) ? (bool) $instance['auto'] : false;	
        ?>

        <p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
			<?php esc_html_e('Title:', 'finance') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'flickrID' ) ); ?>">
			<?php esc_html_e('Flickr ID:', 'finance') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'flickrID' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'flickrID' ) ); ?>" value="<?php echo esc_attr( $instance['flickrID'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'imgcount' ) ); ?>">
			<?php esc_html_e('Number of Photos:', 'finance') ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'imgcount' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'imgcount' ) ); ?>" class="widefat">
			    <option value="3" <?php selected( '3', $instance['imgcount'] ); ?>>
			    <?php esc_html_e( '3', 'finance' ) ?></option>
			    <option value="6" <?php selected( '6', $instance['imgcount'] ); ?>>
			    <?php esc_html_e( '6', 'finance' ) ?></option>
			    <option value="8" <?php selected( '8', $instance['imgcount'] ); ?>>
			    <?php esc_html_e( '8', 'finance' ) ?></option>
			    <option value="9" <?php selected( '9', $instance['imgcount'] ); ?>>
			    <?php esc_html_e( '9', 'finance' ) ?></option>
			    <option value="12" <?php selected( '12', $instance['imgcount'] ); ?>>
			    <?php esc_html_e( '12', 'finance' ) ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>">
			<?php esc_html_e('Type:', 'finance') ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'type' ) ); ?>" class="widefat">
			    <option value="user" <?php selected( 'user', $instance['type'] ); ?>>
			    <?php esc_html_e( 'User', 'finance' ) ?></option>
			    <option value="group" <?php selected( 'group', $instance['type'] ); ?>>
			    <?php esc_html_e( 'Group', 'finance' ) ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'display' ) ); ?>"><?php esc_html_e('Display:', 'finance') ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'display' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'display' ) ); ?>" class="widefat">
			    <option value="random" <?php selected( 'random', $instance['display'] ); ?>>
			    <?php esc_html_e( 'Random', 'finance' ) ?></option>
			    <option value="latest" <?php selected( 'latest', $instance['display'] ); ?>>
			    <?php esc_html_e( 'Latest', 'finance' ) ?></option>
			</select>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $auto ); ?> id="<?php echo esc_attr( $this->get_field_id( 'auto' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'auto' ) ); ?>" />
            <label for="<?php echo esc_attr( $this->get_field_id( 'auto' ) ); ?>">
            <?php esc_html_e( 'Auto change image?', 'finance' ) ?></label>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'item_in_row' ) ); ?>">
            <?php esc_html_e( 'Show items in row:', 'finance' ) ?></label>
        	<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'item_in_row' ) ); ?>" class="widefat" name="<?php echo esc_attr( $this->get_field_name('item_in_row') ); ?>" value="<?php echo esc_attr( $instance['item_in_row'] ); ?>">
    	</p>
		
    <?php
    }

}

add_action( 'widgets_init', 'themesflat_register_flicker' );

/**
 * Register widget
 *
 * @return void
 * @since 1.0
 */
function themesflat_register_flicker() {
    register_widget( 'Themesflat_Flicker' );
}
