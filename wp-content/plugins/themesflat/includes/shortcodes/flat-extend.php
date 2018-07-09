<?php
if ( ! class_exists('Flat_VCExtend') ) {
	class Flat_VCExtend {
	    function __construct() {
			// We safely integrate with VC with this hook
			add_action( 'init', array( $this, 'integrateWithVC' ) );

			// Use this when creating a shortcode addon
			$shortcodes = 'portfolio,posts';
			$shortcodes = explode(",", $shortcodes);
			$shortcodes = array_map("trim", $shortcodes);
			foreach ( $shortcodes as $shortcode ) {
				add_shortcode($shortcode, array( $this, 'themesflat_'.$shortcode ) );
			}
	    }

	    public function integrateWithVC() {
	        // Check if Visual Composer is installed
	        if ( ! defined( 'WPB_VC_VERSION' ) ) {
	            // Display notice that Visual Compser is required
	            add_action('admin_notices', array( $this, 'showVcVersionNotice' ));
	            return;
	        }		
			
			//portfolio option
			$category_portfolio = get_terms( 'portfolios_category' );
			$category_portfolio_name[] = 'All';

			foreach ( $category_portfolio as $category ) {
				$category_portfolio_name[] = $category->name;		
			}

				vc_map( array(
				'base'        => 'portfolio',
				'icon'        => 'themesflat-shortcode',
				'name'        => esc_html__( 'Themesflat: Portfolio', 'Finance' ),
				'category'    => esc_html__( 'Themesflat', 'Finance' ),
				'params'      => array(
					array(
						"type"        => "dropdown",
						"heading" => esc_html__("Category", 'Finance'),
						"param_name" => "category",
						"value"       => $category_portfolio_name,
						"description" => esc_html__("Display posts from some categories.", 'Finance'),
		          	),	

					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Style', 'Finance' ),
						'param_name' => 'style',
						'value' => array(
							esc_html__( 'Grid', 'Finance' )           => 'grid',
							esc_html__( 'Grid Masonry', 'Finance' )   => 'masonry',
							esc_html__( 'Grid No Margin', 'Finance' ) => 'no-margin'
						)
					),

					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Grid Columns', 'Finance' ),
						'param_name' => 'columns',
						'value'      => array(
							esc_html__( '3 Columns', 'Finance' ) => 'one-three',
							esc_html__( '2 Columns', 'Finance' ) => 'one-half',							
							esc_html__( '4 Columns', 'Finance' ) => 'one-four',
							esc_html__( '5 Columns', 'Finance' ) => 'one-five'
						)
					),

					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Number Of Items', 'Finance' ),
						'param_name' => 'limit',
						'value'      => 8
					),				

					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Enable Carousel Mode', 'Finance' ),
						'param_name' => 'enable_carousel',
						'value' => array( esc_html__( 'Yes, please', 'Finance' ) => 'yes' )
					),

					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Hide title portfolio', 'Finance' ),
						'param_name' => 'hide_title',
						'value' => array( esc_html__( 'Yes, please', 'Finance' ) => 'yes' )
					),

					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Hide category portfolio', 'Finance' ),
						'param_name' => 'hide_category',
						'value' => array( esc_html__( 'Yes, please', 'Finance' ) => 'yes' )
					),

					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Show Filter', 'Finance' ),
						'param_name' => 'show_filter',
						'description' => esc_html__( 'If "YES" portfolio filter will be shown.', 'Finance' ),
						'value' => array(
							esc_html__( 'No', 'Finance' ) => 'no',
							esc_html__( 'Yes, please', 'Finance' ) => 'yes'							
						)
					),

					array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Show Portfolio Content', 'Finance' ),
						'param_name' => 'show_content',
						'value'      => array(
							esc_html__( 'Yes, please', 'Finance' ) => 'yes'
						)
					),

					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Portfolio Content Length', 'Finance' ),
						'param_name' => 'content_length',
						'value'      => 150
					),

					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Extra Class', 'Finance' ),
						'param_name' => 'class'
					),

					array(
						'type' => 'css_editor',
						'param_name' => 'css',
						'group' => esc_html__( 'Design Options', 'Finance' )
					)
				)
	        
	        ));    
			
			/**
			 * Map the post shortcode
			 */
			$category_posts = get_terms( 'category' );
			$category_posts_name[] = 'All';
			foreach ( $category_posts as $category_post ) {
				$category_posts_name[] = $category_post->name;		
			}

			vc_map( array(
				'name'                    => esc_html__( 'Themesflat: Blog Posts', 'Finance' ),
				'base'                    => 'posts',
				'params'                  => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Widget Title', 'Finance' ),
						'param_name'  => 'title',
						'description' => esc_html__( 'Enter text widget', 'Finance' )
					),
					array(
						"type"        => "dropdown",
						"heading" => esc_html__("Category", 'Finance'),
						"param_name" => "category_post",
						"value"       => $category_posts_name,
						"description" => esc_html__("Display posts from categories.", 'Finance'),
		          	),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Layout', 'Finance' ),
						'param_name' => 'layout',
						'value'      => array(
							esc_html__( 'Grid', 'Finance' ) => 'grid',
							esc_html__( 'List', 'Finance' ) => 'list',
							esc_html__( 'Masonry', 'Finance' ) => 'masonry'
						)
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Grid Columns', 'Finance' ),
						'param_name'  => 'grid_columns',
						'description' => esc_html__( 'The number of columns for grid and grid masonry layout', 'Finance' ),
						'value'       => array(
							esc_html__( '1 Column', 'Finance' ) => 1,
							esc_html__( '2 Columns', 'Finance' ) => 2,
							esc_html__( '3 Columns', 'Finance' ) => 3,
							esc_html__( '4 Columns', 'Finance' ) => 4
						)
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Limit', 'Finance' ),
						'param_name'  => 'limit',
						'description' => esc_html__( 'Set numbers of post you want to display', 'Finance' ),
						'value'       => 9
					),
					array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Hide Content', 'Finance' ),
						'param_name' => 'hide_content',
						'value'      => array(
							esc_html__( 'Yes, please', 'Finance' ) => 'yes'
						)
					),
					array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Enable Carousel', 'Finance' ),
						'param_name' => 'blog_carousel',
						'value'      => array(
							esc_html__( 'Yes, please', 'Finance' ) => 'yes'
						)
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Post Content Length', 'Finance' ),
						'param_name' => 'content_length',
						'value'      => 150
					),
					array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Hide Read More', 'Finance' ),
						'param_name' => 'hide_readmore',
						'value'      => array(
							esc_html__( 'Yes, please', 'Finance' ) => 'yes'
						)
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Read More Text', 'Finance' ),
						'param_name' => 'readmore_text',
						'value'      => esc_html__( 'Continue', 'Finance' )
					),

					array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Show Pagination', 'Finance' ),
						'param_name' => 'show_pagination',
						'value'      => array(
							esc_html__( 'Yes, please', 'Finance' ) => 'yes'
						)
					),

					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'Finance' ),
						'param_name'  => 'class',
						'description' => esc_html__( 'Enter your class.', 'Finance' )
					),

					array(
						'type'       => 'css_editor',
						'param_name' => 'css',
						'group'      => esc_html__( 'Design Options', 'Finance' )
					)
				)
			) );

	    }    
		
		// Portfolio render
		public static function themesflat_portfolio( $atts, $content = null ) {
			extract( shortcode_atts( array(	
				'style'			  => 'grid',
				'limit'		      => 8,	
				'columns'		  => 'one-three',
				'show_filter'	  => '',
				'category'		  => 'All',
				'exclude'         => '',
				'enable_carousel' => 'no',	
				'hide_title'	  => 'no',
				'show_content'    => 'no',
				'content_length'    => 150,
				'hide_category'	  => 'no',	
				'css'             => '',
				'class'           => '',
				'orderby'   => '',
        		'order' => '',			
			), $atts ) );

			
			if ( empty( $atts['enable_carousel'] ) ) $atts['enable_carousel'] = 'no';
			if ( empty( $atts['show_filter'] ) ) $atts['show_filter'] = 'no';
			if ( empty( $atts['show_content'] ) ) $atts['show_content'] = 'no';

			ob_start();
			$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

			$limit = intval( $limit );		
			$terms_slug = wp_list_pluck( get_terms( 'portfolios_category','orderby=name&hide_empty=0'), 'slug' );        
	        $tax =  $terms_slug;
	        
	        if ( $category != 'All' ) {            
	            $tax = $category;
	        }		

	        if ( get_query_var('paged') ) {
	           $paged = get_query_var('paged');
	        } elseif ( get_query_var('page') ) {
	           $paged = get_query_var('page');
	        } else {
	           $paged = 1;
	        }    

			$query_args = array(
	            'post_type' => 'portfolios',
	            'orderby'   => $orderby,
	            'order' => $order,
	            'posts_per_page' => $limit,
	            'paged' => $paged,          
	            'tax_query' => array(
	                array(
	                    'taxonomy' => 'portfolios_category',   
	                    'field'    => 'slug',                   
                    	'terms'    => $tax,
	                ),
	            ),
	        );

	        if ( ! empty( $atts['exclude'] ) ) {
				$exclude = $atts['exclude'];				
				if ( ! is_array( $exclude ) )
					$exclude = explode( ',', $exclude );

				$query_args['post__not_in'] = $exclude;
			}

			$query = new WP_Query( $query_args );
			$GLOBALS['wp_query']->max_num_pages = $query->max_num_pages; 
		
			if ( ! $query->have_posts() )
				return;			

			wp_enqueue_script( 'themesflat-carousel' );

			echo '<div class="flat-portfolio '.$atts['enable_carousel'].'">'; 
            $show_filter_portfolio = '';

			//Build the filter navigation
	        if ( $show_filter == "yes" ) {	   
	        	$show_filter_portfolio = 'show_filter_portfolio';     	
	            $terms = get_terms('portfolios_category','orderby=name&hide_empty=0');            
	            if ( count($terms) > 0 ) { 
	                echo '<ul class="portfolio-filter '.esc_attr( $class ).'"><li class="active"><a data-filter="*" href="#">' . esc_html__( 'All', 'finance' ) . '</a></li>';                
	                foreach ( $terms as $term ) {
	                    $termname = strtolower( $term->name );  
	                    $termname = str_replace(' ', '-', $termname);
	                    echo '<li><a data-filter=".' . esc_attr( $termname ) . '" href="#" title="' . esc_attr( $term->name ) . '">' . esc_html( $term->name ) . '</a></li>';                                  
	                }
	                echo '</ul>'; //portfolio-filter
	            }
	        } 
	        echo '<div class="portfolio-container '.esc_attr( $class ).' '.esc_attr( $style ).' '.esc_attr( $columns ).' '.esc_attr( $show_filter_portfolio ).'">';        
			while ( $query->have_posts() ) : $query->the_post();
			global $post;
	        $id = $post->ID;
	        $termsArray = get_the_terms( $id, 'portfolios_category' );
	        $termsString = "";
	         
	        if ( $termsArray ) {
	            foreach ( $termsArray as $term ) {
	            	$itemname = strtolower( $term->name ); 
	                $itemname = str_replace( ' ', '-', $itemname );
	                $termsString .= $itemname.' ';
	            }
	        }

	        $img_portfolio = 'themesflat-portfolio-thumb';
	        
	        if ( $style == 'masonry' ) {
	        	$img_portfolio = 'post-thumbnails';
	        }

	        if ( has_post_thumbnail() ):	

	        	// Enqueue shortcode assets
				wp_enqueue_script( 'themesflat-manific-popup' );
				echo '<div class="item ' . $termsString . '">';
				echo '<div class="wrap-border">';
	            echo '<div class="featured-post">';	            
	            echo '<div class="link"><a class="popup-gallery" href="'.themesflat_thumbnail_url('').'"><i class="fa fa-arrows-alt"></i></a></div>';	            
	            echo '<img src="'.themesflat_thumbnail_url( $img_portfolio ).'" alt="'.get_the_title() .'">';	                                                                   
	            echo '</div>';	            
	            if ( $hide_title != 'yes' ) {
	            	echo '<div class="title-post"><a title="' . get_the_title() . '" href="' . get_the_permalink() . '">' . get_the_title() . '</a></div>';
	            }
	            
	            if ( $hide_category != 'yes' ) {	
                    echo '<div class="category-post">';
                    echo the_terms( get_the_ID(), 'portfolios_category', 
                        '', ' / ', '' );                        
                    echo '</div>';     
                }	
                
                if ( $atts['show_content'] != 'no' ):
                ?>
									
					<div class="entry-content">

						<?php
							$content = get_the_content();
							$content = trim( strip_tags( $content ) );
							$length  = intval( '0' . $atts['content_length'] );
							$length  = max( $length, 1 );

							if ( mb_strlen( $content ) > $length ) {
								$content = mb_substr( $content, 0, $length );
								$content.= '...';
							}

							echo wp_kses_post( $content );
						?>					

					</div>

				<?php endif;  
	            
	            echo '</div>';
	            echo '</div>';
	            			
			endif;
			endwhile;	
			wp_reset_postdata();
			
			echo "</div>";
			echo "</div>";
			$out_put = ob_get_clean();
			return $out_put;
		}	

		// Blog post render
		public static function themesflat_posts( $atts, $content = null ) {
			$atts = shortcode_atts( apply_filters( 'themesflat/shortcode/posts_atts', array(
				'class'        		=> '',
				'css'          		=> '',
				
				'title'        		=> '',
				'category_post'     => 'All',				
				'layout'       		=> 'grid', // grid, masonry, list
				'grid_columns' 		=> 3,
				'hide_content' 		=> '',
				'blog_carousel' => '',
				'show_pagination' 	=> '',
				'content_length'    => 150,
				'exclude'      		=> '',
				'page'				=> 1,

				'hide_readmore' 	=> '',
				'readmore_text' 	=> esc_html__( 'Continue', 'finance' ),
				
				'limit'        => 9,				
				) ), $atts );

			ob_start();
			$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content	

			if ( get_query_var('paged') ) {
	           $paged = get_query_var('paged');
	        } elseif ( get_query_var('page') ) {
	           $paged = get_query_var('page');
	        } else {
	           $paged = 1;
	        }     				

			$query_args = array(					
				'post_status'         => 'publish',
				'post_type'           => 'post',
				'paged' => $paged,
				'ignore_sticky_posts' => true,
			);  

			if ( is_numeric( $atts['limit'] ) && $atts['limit'] >= 0 ) {
				$query_args['posts_per_page'] = $atts['limit'];
			}

			if ( ! empty( $atts['exclude'] ) ) {
				$exclude = $atts['exclude'];

				if ( ! is_array( $exclude ) )
					$exclude = explode( ',', $exclude );

				$query_args['post__not_in'] = $exclude;
			}
			
			if ( $atts['category_post'] != 'All' )
			$query_args['category_name'] = $atts['category_post'];

			$query = new WP_Query( $query_args );	
			$GLOBALS['wp_query']->max_num_pages = $query->max_num_pages; 

			$class_names = array(
				1 => 'blog-one-column',
				2 => 'blog-two-columns',
				3 => 'blog-three-columns',
				4 => 'blog-four-columns',
			);		
		
			if ( ! $query->have_posts() )
				return;

			$class = apply_filters( 'themesflat/shortcode/posts_class', array( 'blog-shortcode', $atts['class'], 'blog-' . $atts['layout'] ), $atts );
	
			if ( $atts['layout'] == 'masonry' ) {
				$class[] = 'blog-grid';
			}			
			
			if ( isset( $class_names[$atts['grid_columns']] ) && in_array( $atts['layout'], array( 'grid', 'masonry' ) ) ) {
				$class[] = $class_names[$atts['grid_columns']];
			}

			if ( $atts['hide_content'] != 'yes' ) {
				$class[] = 'has-post-content';
			}	

			if ( $atts['blog_carousel'] == 'yes' ) {
				$class[] = 'has-carousel';
			}

			wp_enqueue_script( 'themesflat-carousel' );
			?>

			<div class="<?php esc_attr_e( implode( ' ', $class ) ) ?>">

			<?php if ( ! empty( $atts['title'] ) ): ?>
				<h3 class="widget-title"><?php esc_html_e( $atts['title'] ) ?></h3>
			<?php endif ?>

			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
	        	<article class="entry">
	        		<div class="entry-border">
						<div class="featured-post">
							<a href="<?php the_permalink();?>">							
								<?php the_post_thumbnail( 'themesflat-blog-shortcode' );?>
							</a>
						</div>
						<div class="content-post">
							<h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>

							<div class="entry-meta clearfix">
								<span class="entry-date"><?php echo get_the_date('d');  ?></span>
								<span class="entry-month"><?php echo get_the_date('M');  ?></span>
							</div><!-- .meta-post -->
							
							<?php if ( $atts['hide_content'] != 'yes' ): ?>
									
								<div class="entry-content">

									<?php
										$content = get_the_content();
										$content = trim( strip_tags( $content ) );
										$length  = intval( '0' . $atts['content_length'] );
										$length  = max( $length, 1 );

										if ( mb_strlen( $content ) > $length ) {
											$content = mb_substr( $content, 0, $length );
											$content.= '...';
										}

										echo wp_kses_post( $content );
									?>

									<?php if ( $atts['hide_readmore'] != 'yes' ): ?>
										<div class="read-more">
											<a href="<?php the_permalink() ?>">
												<?php esc_html_e( $atts['readmore_text'] ) ?>
											</a>
										</div>
									<?php endif ?>

								</div>

							<?php endif ?>
						</div>
					</div>
				</article><!-- /.entry -->

			<?php
			endwhile;
			wp_reset_postdata();
			echo '</div>'; 	
			if ( $atts['show_pagination'] == 'yes' ):
			get_template_part( 'tpl/pagination' );   
			endif; 
			$out_put = ob_get_clean();
			return $out_put;		
			?>
			<?php 				
		}	
	}
}

// Finally initialize code
new Flat_VCExtend();



