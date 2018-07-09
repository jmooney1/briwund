<?php
class Themesflat_Categories extends WP_Widget {
    /**
     * Holds widget settings defaults, populated in constructor.
     *
     * @var array
     */
    protected $defaults;

    /**
     * Constructor
     *
     * @return Themesflat_Categories
     */
    function __construct() {
        $this->defaults = array(
            'title'         => 'Categories',
            'count'         => 10,
            'child_of'      => 'false',
            'show_count'    => 0
        );

        parent::__construct(
            'widget_categories',
            esc_html__( 'flat - Categories', 'finance' ),
            array(
                'classname'   => 'widget_categories',
                'description' => esc_html__( 'Categories.', 'finance' )
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

        echo $before_widget;
        if ( !empty($title) ) echo  $before_title.$title.$after_title;?>

        <ul>
            <?php wp_list_categories('show_count=' . (bool)( $show_count ) . '&number=' . intval( $count ) . '&title_li=&child_of=' . intval( $child_of ) ); ?> 
        </ul><!--/.tags -->

        <?php echo $after_widget;

    }

    /**
     * Update widget
     */
    function update( $new_instance, $old_instance ) {

        $instance                   = $old_instance;

        $instance['title']          = strip_tags( $new_instance['title'] );
        $instance['count']          = intval( $new_instance['count'] );
        $instance['child_of']       = intval( $new_instance['child_of'] );
        $instance['show_count']     = isset( $new_instance['show_count'] ) ? (bool) $new_instance['show_count'] : false;
        
        return $instance;
    }

    /**
     * Widget setting
     */
    function form( $instance ) {

        $instance = wp_parse_args( $instance, $this->defaults );
        $show_count = isset( $instance['show_count'] ) ? (bool) $instance['show_count'] : false;
        ?>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'finance' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Count:', 'finance' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="text" value="<?php echo intval( $instance['count'] ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'child_of' ) ); ?>"><?php esc_html_e( 'Child Of:', 'finance' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'child_of' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'child_of' ) ); ?>" type="text" value="<?php echo intval( $instance['child_of'] ); ?>">
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked( $show_count ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_count' ) ); ?>" />
            <label for="<?php echo esc_attr( $this->get_field_id( 'show_count' ) ); ?>"><?php esc_html_e( 'Show count?', 'finance' ); ?></label>
        </p>

    <?php
    }

}

add_action( 'widgets_init', 'themesflat_register_categories' );

/**
 * Register widget
 *
 * @return void
 * @since 1.0
 */
function themesflat_register_categories() {
    register_widget( 'Themesflat_Categories' );
}
