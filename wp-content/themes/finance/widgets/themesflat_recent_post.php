<?php
class Themesflat_Recent_Post extends WP_Widget {
    /**
     * Holds widget settings defaults, populated in constructor.
     *
     * @var array
     */
    protected $defaults;

    /**
     * Constructor
     *
     * @return Themesflat_Recent_Post
     */
    function __construct() {
        $this->defaults = array(
            'title' 	=> 'Recent Post', 
            'category'  => '',
            'count' 	=> 4,
            'show_content' => false,
            'show_date' => true           
        );

        parent::__construct(
            'widget_recent_post',
            esc_html__( 'Themesflat - Recent Post', 'finance' ),
            array(
                'classname'   => 'widget-recent-news',
                'description' => esc_html__( 'Recent Post.', 'finance' )
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

        $query_args = array(
            'post_type' => 'post',
            'posts_per_page' => intval($count)
        );

        if ( !empty( $category ) )
            $query_args['tax_query'] = array(
                array(
                    'taxonomy' => 'category',
                    'terms'    => $category,
                ),
            );             
       
        $themesflat_post = new WP_Query( $query_args );
        echo $before_widget;

		if ( !empty($title) ) { echo  $before_title.$title.$after_title; } ?>		
        <ul class="recent-news clearfix">  
		<?php if ( $themesflat_post->have_posts() ) : ?>
			<?php while ( $themesflat_post->have_posts() ) : $themesflat_post->the_post(); ?>
				<li>
                    <?php if ( has_post_thumbnail()) : ?>
                    <div class="thumb">
                        <span class="overlay-pop"></span>
                        <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail( 'themesflat-recent-news-thumb'); ?>
                        </a>
                    </div>
                    <?php endif; ?>                       
                    <div class="text">
                        <?php 
                        the_title( sprintf( '<h4><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
                        ?>                        
                        <?php if ( $show_content ) : ?>
                        <p><?php echo wp_trim_words( get_the_content(), 8, '...' ); ?></p>
                        <?php endif; ?>
                        <?php if ( $show_date ) : ?>
                        <p><time class="date updated" datetime="<?php esc_attr(the_time( 'c' )); ?>"><?php the_time( get_option( 'date_format' ) ); ?></time></p>
                        <?php endif; ?>
                    </div><!-- /.text -->                        
			    </li>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
			<?php else : ?>  
            <?php printf( '<li>%s</li>',esc_html('Oops, category not found.', 'finance' )); ?>
		<?php endif; ?>        
        </ul>		
		<?php echo $after_widget;
    }

    /**
     * Update widget
     */
    function update( $new_instance, $old_instance ) {

        $instance               = $old_instance;

        $instance['title']      = strip_tags( $new_instance['title'] );
        $instance['count']      =  intval($new_instance['count']);
        $instance['show_date']     = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
        $instance['show_content']     = isset( $new_instance['show_content'] ) ? (bool) $new_instance['show_content'] : false;       
        $instance['category']           = array_filter( $new_instance['category'] );        
        return $instance;
    }

    /**
     * Widget setting
     */
    function form( $instance ) {

        $instance = wp_parse_args( $instance, $this->defaults );
        $show_content = $instance['show_content'] ? "checked" : "";
        $show_content   = isset( $instance['show_content'] ) ? (bool) $instance['show_content'] : false;
        $show_date = $instance['show_date'] ? "checked" : "";
        $show_date   = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
        ?>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'finance' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php esc_html_e( 'Select Category:', 'finance' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>[]">
                <option value=""<?php selected( empty( $instance['category'] ) ); ?>><?php esc_html_e( 'All', 'finance' ); ?></option>
                <?php               
                $categories = get_categories();
                foreach ($categories as $category) {
                    printf('<option value="%1$s" %4$s>%2$s (%3$s)</option>', esc_attr($category->term_id), esc_attr($category->name), esc_attr($category->count), (in_array($category->term_id, $instance['category'] )) ? 'selected="selected"' : '');
                }               

                ?>
            </select>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Count:', 'finance' ); ?></label>
            <input class="widefat" type="number" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" value="<?php echo esc_attr( $instance['count'] ); ?>">
        </p>

        <p>
            <input class="checkbox" type="checkbox" <?php checked( $show_content ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_content' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_content' ) ); ?>" />
            <label for="<?php echo esc_attr( $this->get_field_id( 'show_content' ) ); ?>"><?php esc_html_e( 'Show Content ?', 'finance' ) ?></label>
        </p>       

        <p>
            <input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_date' ) ); ?>" />
            <label for="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>"><?php esc_html_e( 'Show Date ?', 'finance' ); ?></label>
        </p>

    <?php
    }

}

add_action( 'widgets_init', 'themesflat_register_recent_post' );

/**
 * Register widget
 *
 * @return void
 * @since 1.0
 */
function themesflat_register_recent_post() {
    register_widget( 'Themesflat_Recent_Post' );
}


